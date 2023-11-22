<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca upload plików oparty o SWF Upload
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */
class MultiUpload extends Input
{
	protected $katalogSzablonu = 'MultiUploadNew';
	protected $parametry = array(
		'swf_upload_cfg' => array(),
	);


	function __construct($nazwa, $parametry = null, $etykieta = null, $opis = null, $szablon = null)
	{
		/*
		 * ŁW: Ten Input jest przestarzały - z racji tego wyrzucam że jest DEPRECATED
		 */
		trigger_error('Ten Input jest przestarzały, użyj w zamian MultiUploadPliko/MultiUploadZdjec. This input is deprecated use MultiUploadPliko/MultiUploadZdjec instead.', E_USER_DEPRECATED);

		$this->nazwa = $nazwa;

		/*
		 * Zamiana kolejnosci argumentow $parametry i $etykiety
		*
		* Sprawdzenie czy argumeny zostaly wprowadzone w stary sposob, jesli tak zamieniamy kolejnosc parametrow $parametry i $etykiety
		*/

		if ((is_array($etykieta) || $etykieta == null) && (is_string($parametry) || $parametry == null))
		{
			$tmp_parametry = $parametry;
			$parametry = $etykieta;
			$etykieta = $tmp_parametry;
		}

		$parametry = (array) $parametry;
		$this->etykieta = $etykieta;
		if (isset($parametry['wartosc']))
		{
			$this->ustawWartosc($parametry['wartosc']);
			unset($parametry['wartosc']);
		}
		if (isset($parametry['wymagany']))
		{
			$this->wymagany = (bool) $parametry['wymagany'];
			unset($parametry['wymagany']);
		}
		$this->parametry = array_merge($this->parametry, $parametry);
		$this->opis = $opis;

		$this->ustawTlumaczenia(Cms::inst()->lang['inputy']);


		if ($this->tpl != null)
		{
			$this->ustawSzablon($szablon);
		}
	}

	function pobierzHtml()
	{
		if (is_array($this->parametry['swf_upload_cfg']) && !empty($this->parametry['swf_upload_cfg']))
		{
			$swf_upload_cfg = '';
			foreach($this->parametry['swf_upload_cfg'] as $nazwa => $wartosc)
			{
				if(is_array($wartosc))
				{
					$wartosci_wew = '';
					foreach($wartosc as $nazwa_ => $wartosc_)
					{
						$wartosci_wew .= $nazwa_.': '.$wartosc_.','."\n";
					}
					$swf_upload_cfg .= $nazwa.': {'.substr($wartosci_wew, 0, -2).'},'."\n";
				}
				else
				{
					$swf_upload_cfg .= $nazwa.': '.$wartosc.','."\n";
				}
			}
		}

		return '
<script type="text/javascript">
<!--
function uploadStart(file) {
	try {
		/* I dont want to do any file validation or anything,  Ill just update the UI and
		return true to indicate that the upload should start.
		It s important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("'.$this->tlumaczenia['input_multi_upload_etykieta_przesylanie'].'");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}

	return true;
}

function fileQueueError(fileObj, error_code, message) {
	try {
		var error_name = "";
		switch(error_code) {
			case SWFUpload.ERROR_CODE_QUEUE_LIMIT_EXCEEDED:
				error_name = "'.$this->tlumaczenia['input_multi_upload_blad_kolejka_za_dluga'].'";
			break;
		}

		if (error_name !== "") {
			alert(error_name);
			return;
		}

		switch(error_code) {
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				image_name = "zerobyte.gif";
			break;
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				image_name = "toobig.gif";
			break;
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			default:
				alert(message);
				image_name = "error.gif";
			break;
		}

		AddImage("images/" + image_name);

	} catch (ex) { this.debug(ex); }

}

function fileDialogComplete(num_files_queued) {
	try {
		if (num_files_queued > 0) {
			//this.startUpload();
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadProgress(fileObj, bytesLoaded) {

	try {
		var percent = Math.ceil((bytesLoaded / fileObj.size) * 100)

		var progress = new FileProgress(fileObj,  this.customSettings.upload_target);
		progress.SetProgress(percent);

		if (percent === 100) {
			progress.SetStatus("'.$this->tlumaczenia['input_multi_upload_etykieta_tworzenie_miniaturek'].'");
			progress.ToggleCancel(false);
			progress.ToggleCancel(true, this, fileObj.id);
		} else {
			progress.SetStatus("'.$this->tlumaczenia['input_multi_upload_etykieta_przesylanie'].' ["+percent+"%]");
			progress.ToggleCancel(true, this, fileObj.id);
		}
	} catch (ex) { this.debug(ex); }
}

function uploadSuccess(fileObj, server_data) {
	try {
		// upload.php returns the thumbnail id in the server_data, use that to retrieve the thumbnail for display

		AddImage("thumbnail.php?id=" + server_data);

		var progress = new FileProgress(fileObj,  this.customSettings.upload_target);

		progress.SetStatus("'.$this->tlumaczenia['input_multi_upload_etykieta_miniaturki_stworzone'].'");
		progress.ToggleCancel(false);


	} catch (ex) { this.debug(ex); }
}

function uploadComplete(fileObj) {
	try {
		/*  I want the next upload to continue automatically so I ll call startUpload here */
		if (this.getStats().files_queued > 0) {
			this.startUpload();
		} else {
			var progress = new FileProgress(fileObj,  this.customSettings.upload_target);
			progress.SetComplete();
			progress.SetStatus("'.$this->tlumaczenia['input_multi_upload_etykieta_koniec_ladowania'].'");
			progress.ToggleCancel(false);
			setTimeout(window.location="'.$_SERVER['REQUEST_URI'].'", 6000);
		}
	} catch (ex) { this.debug(ex); }
}

function uploadError(fileObj, error_code, message) {
	var image_name =  "error.gif";
	try {
		switch(error_code) {
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				try {
					var progress = new FileProgress(fileObj,  this.customSettings.upload_target);
					progress.SetCancelled();
					progress.SetStatus("Stopped");
					progress.ToggleCancel(true, this, fileObj.id);
				}
				catch (ex) { this.debug(ex); }
			case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
				image_name = "uploadlimit.gif";
			break;
			default:
				alert(message);
			break;
		}
		AddImage("images/" + image_name);

	} catch (ex) { this.debug(ex); }
}


/* ******************************************
 *	FileProgress Object
 *	Control object for displaying file info
 * ****************************************** */

function FileProgress(fileObj, target_id) {
	this.file_progress_id = "divFileProgress";

	this.fileProgressWrapper = document.getElementById(this.file_progress_id);
	if (!this.fileProgressWrapper) {
		this.fileProgressWrapper = document.createElement("div");
		this.fileProgressWrapper.className = "progressWrapper";
		this.fileProgressWrapper.id = this.file_progress_id;

		this.fileProgressElement = document.createElement("div");
		this.fileProgressElement.className = "progressContainer";

		var progressCancel = document.createElement("a");
		progressCancel.id = "btnCancel";
		progressCancel.className = "progressCancel";
		progressCancel.href = "#";
		progressCancel.style.visibility = "hidden";
		progressCancel.appendChild(document.createTextNode(" "));

		var progressText = document.createElement("div");
		progressText.className = "progressName";
		progressText.appendChild(document.createTextNode(fileObj.name));

		var progressBar = document.createElement("div");
		progressBar.className = "progressBarInProgress";

		var progressStatus = document.createElement("div");
		progressStatus.className = "progressBarStatus";
		progressStatus.innerHTML = "&nbsp;";

		this.fileProgressElement.appendChild(progressCancel);
		this.fileProgressElement.appendChild(progressText);
		this.fileProgressElement.appendChild(progressStatus);
		this.fileProgressElement.appendChild(progressBar);

		this.fileProgressWrapper.appendChild(this.fileProgressElement);

		document.getElementById(target_id).appendChild(this.fileProgressWrapper);
		FadeIn(this.fileProgressWrapper, 0);

	} else {
		this.fileProgressElement = this.fileProgressWrapper.firstChild;
		this.fileProgressElement.childNodes[1].firstChild.nodeValue = fileObj.name;
	}

	this.height = this.fileProgressWrapper.offsetHeight;

}
FileProgress.prototype.SetProgress = function(percentage) {
	this.fileProgressElement.className = "progressContainer green";
	this.fileProgressElement.childNodes[3].className = "progressBarInProgress";
	this.fileProgressElement.childNodes[3].style.width = percentage + "%";
}
FileProgress.prototype.SetComplete = function() {
	this.fileProgressElement.className = "progressContainer blue";
	this.fileProgressElement.childNodes[3].className = "progressBarComplete";
	this.fileProgressElement.childNodes[3].style.width = "";

}
FileProgress.prototype.SetError = function() {
	this.fileProgressElement.className = "progressContainer red";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

}
FileProgress.prototype.SetCancelled = function() {
	this.fileProgressElement.className = "progressContainer";
	this.fileProgressElement.childNodes[3].className = "progressBarError";
	this.fileProgressElement.childNodes[3].style.width = "";

}
FileProgress.prototype.SetStatus = function(status) {
	this.fileProgressElement.childNodes[2].innerHTML = status;
}

FileProgress.prototype.ToggleCancel = function(show, upload_obj, file_id) {
	this.fileProgressElement.childNodes[0].style.visibility = show ? "visible" : "hidden";
	if (upload_obj) {
		this.fileProgressElement.childNodes[0].onclick = function() { upload_obj.cancelUpload(); return false; };
	}
}

function AddImage(src) {
	var new_img = document.createElement("img");
	new_img.style.margin = "5px";

	document.getElementById("thumbnails").appendChild(new_img);
	if (new_img.filters) {
		try {
			new_img.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
		} catch (e) {
			// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
			new_img.style.filter = \'progid:DXImageTransform.Microsoft.Alpha(opacity=\' + 0 + \')\';
		}
	} else {
		new_img.style.opacity = 0;
	}

	new_img.onload = function () { FadeIn(new_img, 0); };
	new_img.src = src;
}

function FadeIn(element, opacity) {
	var reduce_opacity_by = 15;
	var rate = 30;	// 15 fps

	if (opacity < 100) {
		opacity += reduce_opacity_by;
		if (opacity > 100) opacity = 100;

		if (element.filters) {
			try {
				element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				element.style.filter = \'progid:DXImageTransform.Microsoft.Alpha(opacity=\' + opacity + \')\';
			}
		} else {
			element.style.opacity = opacity / 100;
		}
	}

	if (opacity < 100) {
		setTimeout(function() { FadeIn(element, opacity); }, rate);
	}
}


var swfu;
$(document).ready(function(){
	swfu = new SWFUpload({
		'.$swf_upload_cfg.'
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		button_placeholder_id : "'.$this->nazwa.'",
		get_params: {"'.Cms::inst()->sesja->nazwaSesji().'" : "'.Cms::inst()->sesja->idSesji.'"},
		// Event Handler Settings - these functions as defined in Handlers.js
		//  The handlers are not part of SWFUpload but are part of my website and control how
		//  my website reacts to the SWFUpload events.
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete
	});
});
-->
</script>
<div style="float: left"><div style="color: red" id="'.$this->nazwa.'">SWF Upload nie działa</div></div>
<input id="start" type="button" onclick="swfu.startUpload();" value="Rozpocznij wysyłanie" name="start" style="margin: 0 0 0 20px;"/>
<div id="divFileProgressContainer" style="height: 75px;"></div>
		';
	}

}
