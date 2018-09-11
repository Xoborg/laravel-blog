(function() {
	var uploadAttachment;

	Trix.config.attachments.preview.caption = {
		name: false,
		size: false
	};

	document.addEventListener("trix-file-accept", function (event) {
		if (!event.file || !event.file.type.startsWith("image/")) {
			event.preventDefault();
		}
	});

	document.addEventListener("trix-attachment-add", function(event) {
		var attachment = event.attachment;

		if (attachment.file) {
			if (attachment.file.type.startsWith("image/")) {
				return uploadAttachment(attachment);
			} else {
				event.preventDefault();
			}
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

		xhr.upload.onprogress = function (event) {
			var progress  = event.loaded / event.total * 100;
			return attachment.setUploadProgress(progress);
		};

		xhr.onload = function () {
			if (xhr.status === 200) {
				var input = document.createElement("INPUT");
				input.setAttribute("name", "image[]");
				input.setAttribute("type", "hidden");
				input.setAttribute("value", xhr.responseText);
				document.getElementById("formPost").appendChild(input);

				return attachment.setAttributes({
					url: xhr.responseText,
					href: xhr.responseText
				});
			}
		};

		return xhr.send(form);

	};
}).call(this);