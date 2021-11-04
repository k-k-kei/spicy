
const deletes = document.querySelectorAll(".delete-back");
deletes.forEach(div => {
    div.addEventListener("click", () => {
        if (!confirm("削除しても良いですか？")) {
            return;
        }
        div.parentNode.submit();
    });
});