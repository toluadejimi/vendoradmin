<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Contracts\Repositories\NotificationRepositoryInterface;
use App\Contracts\Repositories\ZoneRepositoryInterface;
use App\Enums\ExportFileNames\Admin\Notification;
use App\Enums\ViewPaths\Admin\Notification as NotificationViewPath;
use App\Exports\PushNotificationExport;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\NotificationAddRequest;
use App\Http\Requests\Admin\NotificationUpdateRequest;
use App\Services\NotificationService;
use App\Traits\NotificationTrait;
use Exception;
use Google_Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class NotificationController extends BaseController
{
    use NotificationTrait;
    public function __construct(
        protected NotificationRepositoryInterface $notificationRepo,
        protected NotificationService $notificationService,
        protected ZoneRepositoryInterface $zoneRepo
    )
    {
    }

    public function index(?Request $request): View|Collection|LengthAwarePaginator|null
    {
        return $this->getAddView($request);
    }

    private function getAddView($request): View
    {
        $notifications = $this->notificationRepo->getListWhere(
            searchValue: $request['search'],
            dataLimit: config('default_pagination'),
        );
        $zones = $this->zoneRepo->getList();
        return view(NotificationViewPath::INDEX[VIEW], compact('notifications','zones'));
    }

    public function add(NotificationAddRequest $request): JsonResponse
    {
        $notification = $this->notificationRepo->add(data: $this->notificationService->getAddData(request: $request));
        $topic = $this->notificationService->getTopic(request: $request);
        $notification->image = $notification->image ? url('/').'/storage/app/public/notification/'.$notification->image: null;

        try {
            $this->sendPushNotificationToTopic($notification, $topic, 'general');
        } catch (Exception) {
            Toastr::warning(translate('messages.push_notification_failed'));
        }

        return response()->json();
    }

    public function getUpdateView(string|int $id): View
    {
        $notification = $this->notificationRepo->getFirstWhere(params: ['id' => $id]);
        $zones = $this->zoneRepo->getList();
        return view(NotificationViewPath::UPDATE[VIEW], compact('notification','zones'));
    }

    public function update(NotificationUpdateRequest $request, $id): RedirectResponse
    {
        $notification = $this->notificationRepo->getFirstWhere(params: ['id' => $id]);
        $notification = $this->notificationRepo->update(id: $id ,data: $this->notificationService->getUpdateData(request: $request,notification: $notification));

        $topic = $this->notificationService->getTopic(request: $request);

        $notification->image = $notification->image ? url('/').'/storage/app/public/notification/'.$notification->image: null;

        try {
            $this->sendPushNotificationToTopic($notification, $topic, 'general');
        } catch (Exception) {
            Toastr::warning(translate('messages.push_notification_failed'));
        }

        Toastr::success(translate('messages.notification_updated_successfully'));
        return back();
    }

    public function updateStatus(Request $request): RedirectResponse
    {
        $this->notificationRepo->update(id: $request['id'] ,data: ['status'=>$request['status']]);
        Toastr::success(translate('messages.notification_status_updated'));
        return back();
    }

    public function delete(Request $request): RedirectResponse
    {
        $this->notificationRepo->delete(id: $request['id']);
        Toastr::success(translate('messages.notification_deleted_successfully'));
        return back();
    }

    public function exportList(Request $request): BinaryFileResponse
    {
        $notifications = $this->notificationRepo->getExportList($request);
        $data=[
            'data' =>$notifications,
            'search' =>$request['search'] ?? null
        ];
        if($request['type'] == 'csv'){
            return Excel::download(new PushNotificationExport($data), Notification::EXPORT_CSV);
        }
        return Excel::download(new PushNotificationExport($data), Notification::EXPORT_XLSX);
    }


    public function sendNotify()
    {


       // dd(date('y:m:d h:i:s'));



        $client = new Google_Client();
        $client->setAuthConfig('service.json');
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $client_token = $client->getAccessToken();
        $access_token = $client_token['access_token'];

        $fcm_token = 'fcTTpBthSYC7dhqroF2R1P:APA91bGxC9Q-VMAVFZ7Sp3pBQx-0FtDIoJtG36Wq_ojkG1vvgY288Q-N4HFlJqLzdwp3s6ZwSEF9597TPdy7-BiCsdqqh_OH3wRyBgm8sWNN6BR7ZjKFbDpma7FVVX0CkHFOBCLY3iSc';


        if (!empty($access_token) && !empty($fcm_token)) {

            $projectId = env('FIREBASE_PROJECT_ID');
            $url = 'https://fcm.googleapis.com/v1/projects/' . $projectId . '/messages:send';

            $data = [
                'message' => [
                    'notification' => [
                        'title' => "hello",
                        'body' => "hi",
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'id' => '1',
                        'status' => 'done',
                    ],
                    'token' => $fcm_token,
                ],
            ];

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            $result = json_decode($result);

            $response = array();
            $response['success'] = true;
            $response['message'] = 'Notification successfully sent.';
            $response['result'] = $result;

            dd($response['result'] = $result);

        } else {
            $response = array();
            $response['success'] = false;
            $response['message'] = 'Missing sender id or token to send notification.';
        }


        return response()->json($response);


//        $cm_token ='fcTTpBthSYC7dhqroF2R1P:APA91bGxC9Q-VMAVFZ7Sp3pBQx-0FtDIoJtG36Wq_ojkG1vvgY288Q-N4HFlJqLzdwp3s6ZwSEF9597TPdy7-BiCsdqqh_OH3wRyBgm8sWNN6BR7ZjKFbDpma7FVVX0CkHFOBCLY3iSc';
//
//        $sender_id = "150419743739";
//        try{
//            $accessToken = getAccessToken();
//            $registrationToken = $cm_token;
//            $title = 'Test Notification';
//            $body = 'This is a test notification sent from PHP';
//
//            $response = sendFCMNotification($accessToken, $sender_id, $registrationToken, $title, $body);
//            echo "Response: " . $response;
//        }
//
//        catch
//        (Exception $e) {
//            echo 'Caught exception: ', $e->getMessage(), "\n";
//        }

    }


}
