function toggleFavorite(id, type, loadData = false) {
    let parent = null;
    if (event.target.childElementCount > 1) {
        parent = event.target;
    } else {
        parent = event.target.parentElement.parentElement;
    }
    if (parent.dataset.favorite == undefined) parent = parent.parentElement;

    if (parent.dataset.favorite == "1") {
        parent.dataset.favorite = "0";
        parent.children.unfavorite.classList.add("d-none");
        parent.children.favorite.classList.remove("d-none");
    } else if (parent.dataset.favorite == "0") {
        parent.dataset.favorite = "1";
        parent.children.unfavorite.classList.remove("d-none");
        parent.children.favorite.classList.add("d-none");
    }
    axios.post(`/favorite`, { id, type }).then(() => {
        swal("تم  بنجاح", "تم التفضيل /ازالة من المفضلة", "success");
    });
    if (loadData) {
        getFavorite();
        document.querySelector(`#favorite-${id}`).remove();
    }
}
