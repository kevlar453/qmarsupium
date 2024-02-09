
<script>
$(document).ready(function() {
  hitdbakun();
  hitselisih();
  akungraf();
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


function akungraf1(){

  var theme = {
      color: [
          '#26B99A', '#C4495E', '#BDC3C7', '#3498DB',
          '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
      ],
      title: {
          itemGap: 4,
          textStyle: {
              fontWeight: 'normal',
              color: '#408829'
          }
      },
      dataRange: {
          color: ['#1f610a', '#97b58d']
      },
      toolbox: {
          color: ['#408829', '#408829', '#408829', '#408829']
      },
      tooltip: {
          backgroundColor: 'rgba(0,0,0,0.5)',
          axisPointer: {
              type: 'line',
              lineStyle: {
                  color: '#408829',
                  type: 'dashed'
              },
              crossStyle: {
                  color: '#408829'
              },
              shadowStyle: {
                  color: 'rgba(200,200,200,0.3)'
              }
          }
      },
      dataZoom: {
          dataBackgroundColor: '#eee',
          fillerColor: 'rgba(64,136,41,0.2)',
          handleColor: '#408829'
      },
      grid: {
          borderWidth: 0
      },
      categoryAxis: {
          axisLine: {
              lineStyle: {
                  color: '#408829'
              }
          },
          splitLine: {
              lineStyle: {
                  color: ['#eee']
              }
          }
      },
      valueAxis: {
          axisLine: {
              lineStyle: {
                  color: '#408829'
              }
          },
          splitArea: {
              show: true,
              areaStyle: {
                  color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
              }
          },
          splitLine: {
              lineStyle: {
                  color: ['#eee']
              }
          }
      },
      timeline: {
          lineStyle: {
              color: '#408829'
          },
          controlStyle: {
              normal: {color: '#408829'},
              emphasis: {color: '#408829'}
          }
      },
      k: {
          itemStyle: {
              normal: {
                  color: '#68a54a',
                  color0: '#a9cba2',
                  lineStyle: {
                      width: 1,
                      color: '#408829',
                      color0: '#86b379'
                  }
              }
          }
      },
      textStyle: {
          fontFamily: 'Arial, Verdana, sans-serif'
      }
  };

  var echartBar = echarts.init(document.getElementById('mainb'), theme);
  var url1 = "<?php echo base_url(); ?>markas/core1/getchartdata/"
  var url2 = "<?php echo base_url(); ?>markas/core1/getcharttgl";


    $.ajax({
      type: 'POST',
      url: url1 + 'D',
      success: function(data1){
        $.ajax({
          type: 'POST',
          url: url1 + 'K',
          success: function(data2){
            $.ajax({
              type: 'POST',
              url: url2,
              success: function(data3){
                echartBar.setOption({
                    title: {
                      text: 'NERACA',
                      subtext: 'All Transactions'
                    },
                    tooltip : {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow',
                label: {
                    show: true
                }
            }
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
                    legend: {
                      data: ['debet', 'kredit']
                    },
                    xAxis: [{
                      type: 'category',
                      data: JSON.parse(data3)
                    }],
                    yAxis: [{
                      type: 'value'
                    }],
                    dataZoom: [
            {
                show: true,
                start: 50,
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
                showDataShadow: false,
                left: '93%'
            }
        ],
                    series: [{
                      name: 'debet',
                      type: 'bar',
                      itemStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(
                            0, 0, 0, 1,
                            [
                                {offset: 0, color: '#83bf06'},
                                {offset: 0.5, color: '#188d00'},
                                {offset: 1, color: '#188d00'}
                            ]
                        )
                    },
                    emphasis: {
                        color: new echarts.graphic.LinearGradient(
                            0, 0, 0, 1,
                            [
                                {offset: 0, color: '#237807'},
                                {offset: 0.7, color: '#237807'},
                                {offset: 1, color: '#83bf06'}
                            ]
                        )
                    }
                },
                      data: JSON.parse(data1),
                      markPoint: {
                        data: [{
                          type: 'max',
                          name: 'tinggi'
                        }, {
                          type: 'min',
                          name: 'rendah'
                        }]
                      },
                      markLine: {
                        data: [{
                          type: 'average',
                          name: 'rata2'
                        }]
                      }
                    }, {
                      name: 'kredit',
                      type: 'bar',
                      itemStyle: {
                    normal: {
                        color: new echarts.graphic.LinearGradient(
                            0, 0, 0, 1,
                            [
                                {offset: 0, color: '#f32f06'},
                                {offset: 0.5, color: '#d82d00'},
                                {offset: 1, color: '#a82d00'}
                            ]
                        )
                    },
                    emphasis: {
                        color: new echarts.graphic.LinearGradient(
                            0, 0, 0, 1,
                            [
                              {offset: 0, color: '#f35f06'},
                              {offset: 0.5, color: '#d80d00'},
                              {offset: 1, color: '#f80d00'}
                            ]
                        )
                    }
                },
                      data: JSON.parse(data2),
                      markPoint: {
                        data: [{
                          type: 'max',
                          name: 'tinggi'
                        }, {
                          type: 'min',
                          name: 'rendah'
                        }]
                      },
                      markLine: {
                        data: [{
                          type: 'average',
                          name: 'rata2'
                        }]
                      }
                    }
                  ]
                  });
                  }
            });
              }
        });

      }
  });

}

</script>
