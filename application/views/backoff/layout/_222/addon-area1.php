
<script>
$(document).ready(function() {
  hitdbakun();
  hitselisih();
  akungraf();
  setTimeout(function(){
    if(varopta == '00'){
      $('.opta2').text('Valid');
      $('.panatas').addClass('hide');
    } else {
      $('.opta2').text('Posting');
      $('.panatas').removeClass('hide');
    }
    $("#myNav").css('height','0%');
    $('.sidebar').css('opacity',1);
  },1000);
});

function hitdbakun() {
  var url = '<?php echo base_url(); ?>markas/core1/hitjur/';
  $.ajax({
    type: 'POST',
    url: url + 'J',
    success: function(data1){
      $.ajax({
        type: 'POST',
        url: url + 'T',
        success: function(data2){
          $('#jjur').html(JSON.parse(data1));
          $('#jtrx').html(JSON.parse(data2));
        }
      });
    }
  });
}

function hitselisih() {
  var url = '<?php echo base_url(); ?>markas/core1/hitsel';
  $.ajax({
    type: 'POST',
    url: url,
    success: function(data){
      $('#selisih').html(JSON.parse(data));
      if(JSON.parse(data)!=0){
        $('#selisih').addClass('red');
        $('#detselisih').html('Memuat kode jurnal...');
        $('#detselisih').addClass('animated infinite flash red');
        dselisih();
      } else {
        $('#selisih').removeClass('red');
      }
    }
  });
}

function dselisih() {
  var url = '<?php echo base_url(); ?>markas/core1/detsel';
  $.ajax({
    type: 'POST',
    url: url,
    success: function(data){
      $('#detselisih').html(JSON.parse(data));
      $('#detselisih').removeClass('animated infinite flash red');
    }
  });
}

function akungraf(){
	$.blockUI({message:'<h1 style="color:#eee;">Mohon Tunggu...</h1>'});
	var dom = document.getElementById("mainb");
	var myChart = echarts.init(dom);
	var app = {};
	option = null;

		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>markas/reports/hitcharts",
			success: function(resprx) {
				option = {
		        legend: {},
		        tooltip: {
		            trigger: 'axis',
		            showContent: false
		        },
	      dataZoom: {
	          dataBackgroundColor: '#eee',
	          fillerColor: 'rgba(64,136,41,0.2)',
	          handleColor: '#408829'
	      },
		        dataset: {
		            source: JSON.parse(resprx)
		        },
		        xAxis: {type: 'category'},
		        yAxis: {gridIndex: 0},
		        grid: {top: '45%'},
		        series: [
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
              {type: 'line', smooth: true, seriesLayoutBy: 'row'},
		            {type: 'line', smooth: true, seriesLayoutBy: 'row'},
		            {
		                type: 'pie',
		                id: 'pie',
		                radius: '30%',
		                center: ['50%', '25%'],
		                label: {
		                    formatter: '{b}: {@2020-01} ({d}%)'
		                },
		                encode: {
		                    itemName: 'periode',
		                    value: '01-2020',
		                    tooltip: '01-2020'
		                }
		            }
		        ],
						dataZoom: [
		{
				show: true,
				start: 0,
				end: 100
		},
		{
				type: 'inside',
				start: 50,
				end: 100
		},
		{
				show: true,
				yAxisIndex: 0,
				filterMode: 'empty',
				width: 30,
				height: '80%',
				showDataShadow: true,
				left: '93%'
		}
	]
		    };

		    myChart.on('updateAxisPointer', function (event) {
		        var xAxisInfo = event.axesInfo[0];
		        if (xAxisInfo) {
		            var dimension = xAxisInfo.value + 1;
		            myChart.setOption({
		                series: {
		                    id: 'pie',
		                    label: {
		                        formatter: '{b}: {@[' + dimension + ']} ({d}%)'
		                    },
		                    encode: {
		                        value: dimension,
		                        tooltip: dimension
		                    }
		                }
		            });
		        }
		    });

		    myChart.setOption(option);
        $.unblockUI();
}
		});


	if (option && typeof option === "object") {
	    myChart.setOption(option, true);
	}
}

</script>
