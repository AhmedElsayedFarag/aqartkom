var imgUpload = document.getElementById("upload-img"),
    imgPreview = document.getElementById("img-preview"),
    imgUploadForm = document.getElementById("form-upload"),
    totalFiles,
    previewTitle,
    previewTitleText,
    img;

imgUpload.addEventListener("change", previewImgs, true);

const isEditMode = () => location.href.search("edit") > 0;

function deleteMedia() {
    let mediaContainer = $(this).parent(".wrapper-thumb");
    let mediaID = mediaContainer.data("id");

    swal({
        title: "هل انت متأكد من الحذف؟",
        text: "لن تتمكن من استعادة هذا الملف مرة أخرى!",
        icon: "warning",
        dangerMode: true,
        buttons: ["الغاء", "موافق"],
    }).then((willDelete) => {
        if (willDelete && mediaID) {
            axios.delete("/user/media/" + mediaID).then(() => {
                deleteImage(mediaContainer);
            });
        }
        if (willDelete && !mediaID) {
            deleteImage(mediaContainer);
        }
    });
}
function deleteImage(mediaContainer) {
    swal("تم الحذف بنجاح", {
        icon: "success",
    });
    mediaContainer.remove();
}
function previewImgs(event) {
    totalFiles = imgUpload.files.length;

    if (!!totalFiles) {
        imgPreview.classList.remove("img-thumbs-hidden");
    }
    if (!isEditMode()) imgPreview.innerHTML = "";
    for (var i = 0; i < totalFiles; i++) {
        wrapper = document.createElement("div");
        wrapper.classList.add("wrapper-thumb");
        removeBtn = document.createElement("span");
        if (isEditMode()) {
            nodeRemove = document.createTextNode("x");
            removeBtn.classList.add("remove-btn");
            removeBtn.appendChild(nodeRemove);
        }

        img = document.createElement("img");
        img.src = URL.createObjectURL(event.target.files[i]);
        img.classList.add("img-preview-thumb");
        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        imgPreview.appendChild(wrapper);
        $(".remove-btn").click(deleteMedia);
    }
}

$(".remove-btn").click(deleteMedia);
