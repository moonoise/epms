
$(".confirm-del").popConfirm({
        title: "ลบรายชื่อ", // The title of the confirm
        content: "คุณต้องการลบรายชื่อนี้ จริงๆ หรือใหม่ ?", // The message of the confirm
        placement: "left", // The placement of the confirm (Top, Right, Bottom, Left)
        container: "body", // The html container
        yesBtn: "ใช่",
        noBtn: "ไม่"
});


$('[data-toggle="tooltip"]').tooltip()