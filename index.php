<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>



<body>
<!-- dashboard -->
<div class="layout">
  <input name="nav" type="radio" class="nav sensor-radio" id="sensor" checked="checked" />
  <div class="page home-page">
    <div class="page-contents">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>SoilMoist</th>
          <th>Temperature</th>
          <th>State</th>
          
        </tr>
      </thead>
      <tbody id="data-container">
      <script>
        // 실시간으로 데이터 업데이트 함수
        function updateData() {
            $.ajax({
                url: 'get_data.php', // 데이터를 가져오는 PHP 파일
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // 데이터 테이블을 비우고 새로운 데이터 추가
                    $("#data-container").empty();
                    data.forEach(function(row) {
                        $("#data-container").append(
                            '<tr>' +
                            '<td>' + row.id + '</td>' +
                            '<td>' + row.date + '</td>' +
                            '<td>' + row.soilMoist + '</td>' +
                            '<td>' + row.temperature + '</td>' +
                            '<td>' + row.state + '</td>' +
                            '</tr>'
                        );
                    });
                    // 다시 업데이트 요청
                    updateData();
                },
                error: function() {
                    // 에러 발생 시 다시 업데이트 요청
                    updateData();
                }
            });
        }

        // 페이지 로드 후 초기 업데이트 함수 호출
        $(document).ready(function() {
            updateData();
        });
    </script>
      </tbody>
    </table>


    </div>
  </div>
  <label class="nav" for="sensor">
    <span>
      Sensor
    </span>


  </label>


  <!-- graph -->

  <input name="nav" type="radio" class="graph-radio" id="graph" />
  <div class="page about-page">
    <div class="page-contents">
    
    <canvas id="soilMoist-chart"></canvas>
    <canvas id="temperature-chart"></canvas>


    </div>
  </div>
  <label class="nav" for="graph">

    <span>
      Graph
      </span>
    </label>

    <script>
  var soilMoistureCtx = document.getElementById('soilMoist-chart').getContext('2d');
  var soilMoistureChart = new Chart(soilMoistureCtx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: 'Soil Moisture',
        data: [],
        borderColor: 'blue',
        fill: false
      }]
    },
    options: {
      scales: {
        x: {
          display: true
        },
        y: {
          display: true
        }
      }
    }
  });

  var temperatureCtx = document.getElementById('temperature-chart').getContext('2d');
  var temperatureChart = new Chart(temperatureCtx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: 'Temperature',
        data: [],
        borderColor: 'red',
        fill: false
      }]
    },
    options: {
      scales: {
        x: {
          display: true
        },
        y: {
          display: true
        }
      }
    }
  });

  // 실시간으로 데이터 업데이트 함수
  function updateGraphs() {
    $.ajax({
      url: 'get_data.php', // 데이터를 가져오는 PHP 파일
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        // 데이터 그래프 업데이트
        var labels = data.map(function(row) {
          return row.date;
        });

        var soilMoistureData = data.map(function(row) {
          return row.soilMoist;
        });

        var temperatureData = data.map(function(row) {
          return row.temperature;
        });

        soilMoistureChart.data.labels = labels;
        soilMoistureChart.data.datasets[0].data = soilMoistureData;
        soilMoistureChart.update();

        temperatureChart.data.labels = labels;
        temperatureChart.data.datasets[0].data = temperatureData;
        temperatureChart.update();

        // 다시 업데이트 요청
        updateGraphs();
      },
      error: function() {
        // 에러 발생 시 다시 업데이트 요청
        updateGraphs();
      }
    });
  }

      // 페이지 로드 후 초기 업데이트 함수 호출
      $(document).ready(function() {
        updateGraphs();
      });
    </script>



    <!-- image -->

  <input name="nav" type="radio" class="image-radio" id="image" />
  <div class="page about-page">
    <div class="page-contents">
    <table> <!-- 테이블 태그 추가 -->
      <tbody id="image-container">
        <!-- 이미지 데이터가 이 위치에 추가될 것입니다. -->
      </tbody>
    </table>
  <script>
        // 실시간으로 데이터 업데이트 함수
        function updateImage() {
    $.ajax({
      url: 'get_data.php', // 데이터를 가져오는 PHP 파일
      method: 'GET',
      dataType: 'json',
      success: function(data) {
        // 데이터 테이블을 비우고 새로운 데이터 추가
        $("#image-container").empty();
        data.forEach(function(row) {
          $("#image-container").append(
            '<figure class="fir-img-figure">' +
            '<img class="fir-author-img fir-clickcircle" src="' + row.imageUrl + '" alt="Image" onclick="window.open(\'' + this.src + '\')">' + 
            '<figcaption>' +
            '<div class="fig-author-figure-title">' + row.id + '</div>' +
            '<div class="fig-author-figure-title">' + row.date + '</div>' +
            '<div class="fig-author-figure-title">' + row.imageUrl + '</div>' +
            '</figcaption>' +
            '</figure>'
          );
        });
        // 다시 업데이트 요청
        updateImage();
      },
      error: function() {
        // 에러 발생 시 다시 업데이트 요청
        updateImage();
      }
    });
  }

  // 페이지 로드 후 초기 업데이트 함수 호출
  $(document).ready(function() {
    updateImage();
  });
    </script>

 
    </div>
  </div>
  <label class="nav" for="image">


    <span>
      Image
      </span>
    </label>


  
</div>
 </body>
</html>