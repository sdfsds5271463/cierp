/*
		[Leo.C, Studio] (C)2004 - 2008
		
   		$Hanization: LeoChung $
   		$E-Mail: who@imll.net $
   		$HomePage: http://imll.net $
   		$Date: 2008/11/8 18:02 $
*/
/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileQueued(file) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("���ڵȴ�...");
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("�������ϴ����ļ����й���.\n" + (message === 0 ? "���Ѵﵽ�ϴ�����" : "�������ѡ�� " + (message > 1 ? "�ϴ� " + message + " �ļ�." : "һ���ļ�.")));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("�ļ��ߴ����.");
			this.debug("�������: �ļ��ߴ����, �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("�޷��ϴ����ֽ��ļ�.");
			this.debug("�������: ���ֽ��ļ�, �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("��֧�ֵ��ļ�����.");
			this.debug("�������: ��֧�ֵ��ļ�����, �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		default:
			if (file !== null) {
				progress.setStatus("δ����Ĵ���");
			}
			this.debug("�������: " + errorCode + ", �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
			document.getElementById(this.customSettings.cancelButtonId).disabled = false;
		}
		
		/* I want auto start the upload and I can do that here */
		this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("�����ϴ�...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("�����ϴ�...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("�ϴ��ɹ�");
		progress.toggleCancel(false);

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("�ϴ�����: " + message);
			this.debug("�������: HTTP����, �ļ���: " + file.name + ", ��Ϣ: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("�ϴ�ʧ��");
			this.debug("�������: �ϴ�ʧ��, �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("������ (IO) ����");
			this.debug("�������: IO ����, �ļ���: " + file.name + ", ��Ϣ: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("��ȫ����");
			this.debug("�������: ��ȫ����, �ļ���: " + file.name + ", ��Ϣ: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("�����ϴ�����.");
			this.debug("�������: �����ϴ�����, �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("�޷���֤.  �����ϴ�.");
			this.debug("�������: �ļ���֤ʧ��, �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus("ȡ��");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("ֹͣ");
			break;
		default:
			progress.setStatus("δ����Ĵ���: " + errorCode);
			this.debug("�������: " + errorCode + ", �ļ���: " + file.name + ", �ļ��ߴ�: " + file.size + ", ��Ϣ: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	var status = document.getElementById("divStatus");
	status.innerHTML = numFilesUploaded + " ���ļ�" + (numFilesUploaded === 1 ? "" : "s") + "���ϴ�.";
}
