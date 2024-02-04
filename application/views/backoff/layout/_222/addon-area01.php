<script>
$(document).ready(function (){
  var ctrj = document.getElementById("check_rajal").getContext("2d");
  var ctri = document.getElementById("check_ranap").getContext("2d");
  window.myLinej = new Chart(ctrj, configrj);
  window.myLinei = new Chart(ctri, configri);
  setcr_prj();
  setcr_pri();
});

setInterval(function(){
  setcr_prj();
//  setcr_pri();
}, 45000);
setInterval(function(){
//  setcr_prj();
  setcr_pri();
}, 55000);

var bulan = "<?php echo date('F');?>";
var randomColorFactor = function() {
    return Math.round(Math.random() * 255);
};
var randomColor = function(opacity) {
    return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.01') + ')';
};

var $progress1 = $('#animrajal');
var $progress2 = $('#animranap');
var configrj = {
    type: 'line',
    data: {
        labels: ["0"],
        datasets: [
          {label: "UGD ", data: [0], fill: false},
          {label: "P.Umum ", data: [0], fill: false},
          {label: "P.KIA ", data: [0], fill: false},
          {label: "P.Gigi ", data: [0], fill: false},
          {label: "P.Obgyn ", data: [0], fill: false},
          {label: "Akupunktur ", data: [0], fill: false},
          {label: "P.Ortopedi ", data: [0], fill: false},
          {label: "P.Dalam ", data: [0], fill: false},
          {label: "P.Bedah ", data: [0], fill: false},
          {label: "Pen.Medik ", data: [0], fill: false}
      ]
    },
    options: {
        title:{ display:true, text:"Jumlah Pasien Rawat Jalan Periode "+bulan},
        animation: {
            duration: 2000,
            onProgress: function(animation) {
                $progress1.attr({
                    value: animation.animationObject.currentStep / animation.animationObject.numSteps,
                });
            },
            onComplete: function(animation) {
                window.setTimeout(function() {
                    $progress1.attr({
                        value: 0
                    });
                }, 2000);
            }
        },
        tooltips: {
            mode: 'label',
        },
        responsive: true,
        scales: {
            xAxes: [{
                scaleLabel: {
                    show: true,
                    labelString: 'Hari'
                }
            }],
            yAxes: [{
                scaleLabel: {
                    show: true,
                    labelString: 'Jumlah'
                },
            }]
        }
    }
};
var configri = {
    type: 'line',
    data: {
        labels: ["0"],
        datasets: [
          {label: "Yosefa ", data: [0], fill: false},
          {label: "Mikaela ", data: [0], fill: false},
          {label: "Helena ", data: [0], fill: false}
      ]
    },
    options: {
        title:{ display:true, text:"Jumlah Pasien Rawat Inap Periode "+bulan},
        animation: {
            duration: 2000,
            onProgress: function(animation) {
                $progress2.attr({
                    value: animation.animationObject.currentStep / animation.animationObject.numSteps,
                });
            },
            onComplete: function(animation) {
                window.setTimeout(function() {
                    $progress2.attr({
                        value: 0
                    });
                }, 2000);
            }
        },
        tooltips: {
            mode: 'label',
        },
        scales: {
            xAxes: [{
                scaleLabel: {
                    show: true,
                    labelString: 'Hari'
                }
            }],
            yAxes: [{
                scaleLabel: {
                    show: true,
                    labelString: 'Jumlah'
                },
            }]
        }
    }
};

function setcr_prj(){
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>markas/core1/upjumpx/igd",
    data: {"data":"check"},
    success: function(data1){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>markas/core1/upjumpx/umum",
        data: {"data":"check"},
        success: function(data2){
          $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>markas/core1/upjumpx/kia",
            data: {"data":"check"},
            success: function(data3){
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>markas/core1/upjumpx/gigi",
                data: {"data":"check"},
                success: function(data4){
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>markas/core1/upjumpx/obgyn",
                    data: {"data":"check"},
                    success: function(data5){
                      $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>markas/core1/upjumpx/jantung",
                        data: {"data":"check"},
                        success: function(data6){
                          $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>markas/core1/upjumpx/orto",
                            data: {"data":"check"},
                            success: function(data7){
                              $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>markas/core1/upjumpx/dalam",
                                data: {"data":"check"},
                                success: function(data8){
                                  $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>markas/core1/upjumpx/bedah",
                                    data: {"data":"check"},
                                    success: function(data9){
                                      $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>markas/core1/upjumpx/penmed",
                                        data: {"data":"check"},
                                        success: function(data10){
                                          $.ajax({
                                            type: "POST",
                                            url: "<?php echo base_url(); ?>markas/core1/upjumtgl",
                                            data: {"data":"check"},
                                            success: function(data11){
                                              configrj.data.datasets = [
                                                {label: "UGD ", data: JSON.parse(data1), fill: true},
                                                {label: "P.Umum ", data: JSON.parse(data2), fill: true},
                                                {label: "P.KIA ", data: JSON.parse(data3), fill: true},
                                                {label: "P.Gigi ", data: JSON.parse(data4), fill: true},
                                                {label: "P.Obgyn ", data: JSON.parse(data5), fill: true},
                                                {label: "Akupunktur ", data: JSON.parse(data6), fill: true},
                                                {label: "P.Ortopedi ", data: JSON.parse(data7), fill: true},
                                                {label: "P.Dalam ", data: JSON.parse(data8), fill: true},
                                                {label: "P.Bedah ", data: JSON.parse(data9), fill: true},
                                                {label: "Pen.Medik ", data: JSON.parse(data10), fill: true}
                                              ];
                                              configrj.data.labels = JSON.parse(data11);
                                              $.each(configrj.data.datasets, function(i, dataset) {
                                                  dataset.borderColor = randomColor(0.4);
                                                  dataset.backgroundColor = randomColor(0.5);
                                                  dataset.pointBorderColor = randomColor(0.7);
                                                  dataset.pointBackgroundColor = randomColor(0.5);
                                                  dataset.pointBorderWidth = 1;
                                              });
                                              window.myLinej.update();
                                            }
                                          })
                                        }
                                      })
                                    }
                                  })
                                }
                              })
                            }
                          })
                        }
                      })
                    }
                  })
                }
              })
            }
          })
        }
      })
    }
  });
}

function setcr_pri(){
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>markas/core1/upjumpi/yos",
    data: {"data":"check"},
    success: function(data1){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>markas/core1/upjumpi/mik",
        data: {"data":"check"},
        success: function(data2){
          $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>markas/core1/upjumpi/hel",
            data: {"data":"check"},
            success: function(data3){
              $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>markas/core1/upjumtgl",
                data: {"data":"check"},
                success: function(data4){
                  configri.data.datasets = [
                    {label: "Yosefa ", data: JSON.parse(data1), fill: true},
                    {label: "Mikaela ", data: JSON.parse(data2), fill: true},
                    {label: "Helena ", data: JSON.parse(data3), fill: true}
                  ];
                  configri.data.labels = JSON.parse(data4);
                  $.each(configri.data.datasets, function(i, dataset) {
                      dataset.borderColor = randomColor(0.4);
                      dataset.backgroundColor = randomColor(0.5);
                      dataset.pointBorderColor = randomColor(0.7);
                      dataset.pointBackgroundColor = randomColor(0.5);
                      dataset.pointBorderWidth = 1;
                  });
                  window.myLinei.update();
                }
              })
            }
          })
        }
      })
    }
  });
}


</script>
