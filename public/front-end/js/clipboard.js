const copyContent = async (link) => {
    try {
        await navigator.clipboard.writeText(link);
        swal("تم النسخ بنجاح", "تم نسخ رابط المشاركة بنجاح", "success");
        console.log("Content copied to clipboard");
    } catch (err) {
        console.error("Failed to copy: ", err);
    }
};
