function openPopUp(obj){
    var data = $(obj).serialize();

    var url = BASE_URL+"Reports/sales_pdf?"+data;

    window.open(url, "Reports", "width=700, height=500");
    return false;
}