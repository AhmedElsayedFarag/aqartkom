const inputFile = document.getElementById("video_uploader");
const video = document.getElementById("video");

inputFile.addEventListener("change", function () {
    const file = inputFile.files[0];
    const videourl = URL.createObjectURL(file);
    video.setAttribute("src", videourl);
    video.play();
});
