<?php

namespace App\Traits;

use App\Models\Attachment;
use Str;

trait AttachmentTrait
{
	public function addAttachment($file)
	{
		if ($file) {
			$name = time() . Str::random(6) . '-' . str_ireplace(' ', '-', $file->getClientOriginalName());
			$file->move('public/uploads', $name);
			$attachment = Attachment::create([
				'attachment' => $name
			]);
			return $attachment->id;
		} else {
			return 0;
		}
	}

	public function removeAttachment($id)
	{
		if (!empty($id)) {
			$attachment = Attachment::find($id);
			if ($attachment) {
				if (file_exists('public/uploads/' . $attachment->attachment)) {
					unlink(('public/uploads/' . $attachment->attachment));
				}
				$attachment->delete();
			}
		}

		return true;
	}
}
