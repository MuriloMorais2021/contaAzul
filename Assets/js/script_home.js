var rel1 = new Chart(document.getElementById("rel1"), {
    type : 'line',
    data:{
        labels:days_list,
        datasets:[{
            label: 'Receitas',
            data:revenue_list,
            fill:false,
            backgroudColor: '#0000FF',
            borderColor: '#0000FF'
        },
        {
            label: 'Despesas',
            data:expenses_list,
            fill:false,
            backgroudColor: '#FF0000',
            borderColor: '#FF0000'
        }]

    }
});

var rel2 = new Chart(document.getElementById("rel2"), {
    type: 'pie',
    data:{
        labels:status_name_list,
        datasets:[{
            data: status_value_list,
            backgroundColor: [
                'rgb(255, 205, 86)',
                'rgb(54, 162, 235)',
                'rgb(255, 99, 132)'
              ]
        }]
    }
});