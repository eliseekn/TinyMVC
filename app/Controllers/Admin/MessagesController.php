<?php

namespace App\Controllers\Admin;

use App\Helpers\Auth;
use App\Helpers\Activity;
use Framework\Http\Redirect;
use Framework\Support\Alert;
use App\Helpers\ReportHelper;
use Framework\Routing\Controller;
use App\Database\Models\UsersModel;
use App\Database\Models\MessagesModel;

class MessagesController extends Controller
{
    /**
     * display list
     *
     * @return void
     */
    public function index(): void
	{
        $messages = MessagesModel::get()->paginate(20);

        $messages_unread = MessagesModel::count()
            ->where('recipient', Auth::get()->id)
            ->and('recipient_status', 'unread')
            ->single()
            ->value;

		$this->render('admin/messages', compact('messages', 'messages_unread'));
	}

	/**
	 * send new message
	 *
	 * @return void
	 */
    public function create(): void
	{
        $id = MessagesModel::insert([
            'sender' => Auth::get()->id,
            'recipient' => $this->request->recipient,
            'message' => $this->request->message
        ]);

        MessagesModel::update(['sender_status' => 'read'])->where('id', $id)->persist();
        Activity::log('Message sent to ' . UsersModel::findSingle($this->request->recipient)->email);
        Redirect::back()->withToast(__('message_sent'))->success();
	}
	
	/**
	 * reply to message
	 *
	 * @return void
	 */
    public function reply(): void
	{
        $id = MessagesModel::insert([
            'sender' => Auth::get()->id,
            'recipient' => $this->request->recipient,
            'message' => $this->request->message
        ]);

        MessagesModel::update(['sender_status' => 'read'])->where('id', $id)->persist();
        Activity::log('Message replied to ' . UsersModel::findSingle($this->request->recipient)->email);
        Redirect::back()->withToast(__('message_sent'))->success();
	}
	
	/**
	 * update
	 *
     * @param  int $id
	 * @return void
	 */
	public function update(int $id): void
	{
        if (!MessagesModel::find($id)->exists()) {
            Redirect::back()->withToast(__('message_not_found'))->error();
        }

        MessagesModel::update(['recipient_status' => 'read'])->where('id', $id)->persist();
        Activity::log('Message marked as read');
        Redirect::back()->withToast(__('message_updated'))->success();
	}

	/**
	 * delete
	 *
     * @param  int|null $id
	 * @return void
	 */
	public function delete(?int $id = null): void
	{
        if (!is_null($id)) {
			if (!MessagesModel::find($id)->exists()) {
				Redirect::back()->withToast(__('message_not_found'))->error();
			}
	
            MessagesModel::deleteWhere('id', $id);
            Activity::log('Message deleted');
            Redirect::back()->withToast(__('message_deleted'))->success();
		} else {
			foreach (explode(',', $this->request->items) as $id) {
				MessagesModel::deleteWhere('id', $id);
			}
            
            Activity::log('Messages deleted');
			Alert::toast(__('messages_deleted'))->success();
		}
	}

	/**
	 * export data
	 *
	 * @return void
	 */
    public function export(): void
	{
        $date_start = $this->request->has('date_start') ? $this->request->date_start : null;
        $date_end = $this->request->has('date_end') ? $this->request->date_end : null;

		if (!is_null($date_start) && !is_null($date_end)) {
			$messages = MessagesModel::select()
                ->whereBetween('created_at', $date_start, $date_end)
                ->orderDesc('created_at')
                ->all();
		} else {
			$messages = MessagesModel::select()->orderDesc('created_at')->all();
        }
        
        $filename = 'messages_' . date('Y_m_d') . '.' . $this->request->file_type;

        Activity::log('Messages exported');

		ReportHelper::export($filename, $messages, [
			'sender' => __('sender'), 
			'recipient' => __('recipient'), 
			'message' => __('message'), 
			'created_at' => __('created_at')
		]);
	}
}
