(function() {
	var uploadAttachment;

	Trix.config.attachments.preview.caption = {
		name: false,
		size: false
	};

	document.addEventListener("trix-attachment-add", function(event) {
		var attachment;
		attachment = event.attachment;
		if (attachment.file) {
			return uploadAttachment(attachment);
		}
	});

	uploadAttachment = function(attachment) {
		var file, form, xhr;
		file = attachment.file;
		form = new FormData;
		form.append("Content-Type", file.type);
		form.append("image", file);
		xhr = new XMLHttpRequest;
		xhr.open("POST", baseUrl + "post-image", true);
		xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
		xhr.upload.onprogress = function(event) {
			var progress;
			progress = event.loaded / event.total * 100;
			return attachment.setUploadProgress(progress);
		};
		xhr.onload = function() {
			var href, url;
			if (xhr.status === 200) {
				url = href = xhr.responseText;
				return attachment.setAttributes({
					url: url,
					href: href
				});
			}
		};
		return xhr.send(form);
	};
}).call(this);