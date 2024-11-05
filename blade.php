<main class="content px-3 py-2">
                <div class="container-fluid" id="dashboard">
                    <div style="padding-top: 20px">
                        <div class="container">
                            <div class="row">
                              <div class="col-3">
                                <div>Passed and Failed</div>
                                <canvas id="topGradesPieChart"></canvas>
                              </div>
                              <div class="col-3">
                                <div>GPA of students</div>
                                <canvas id="pieChart2"></canvas>
                              </div>
                              <div class="col-3">
                                <div>Average GPA of Sections</div>
                                <canvas id="pieChart3"></canvas>
                              </div>
                              <div class="col-3">
                                <div>Students Per Section</div>
                                <canvas id="pieChart4"></canvas>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>Students Per Section</div>
                        <canvas id="sectionCount"></canvas>
                    </div>
                </div>
            </main>

<!--TANGGALIN MO DIVS DI MAAYOS YAN!--> 

<!--JS DITO-->

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/dashboard.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
<script>
    $(document).ready(async () => {
        fetch("/dashboard-pass-and-failed", {
            method: "GET"
        }).then((res) => {
            return res.text();
        }).then((res) => {
            const dashboardPassAndFailedRes = JSON.parse(res);

            pieChartData1 = {
                "labels": ["Passed", "Failed"],
                "data": [dashboardPassAndFailedRes.passed, dashboardPassAndFailedRes.failed],
                "colors": ["rgb(49,138,252)", "rgb(30,121,83)"]
            };

            var myPieChart1 = new Chart(document.getElementById('topGradesPieChart'), {
                type: 'pie',
                data: {
                    labels: pieChartData1.labels,
                    datasets: [{
                        data: pieChartData1.data,
                        backgroundColor: pieChartData1.colors,
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: true,
                        caretPadding: 10,
                    },
                    legend: {
                        display: true
                    },
                    cutoutPercentage: 10,
                },
            });
        });

        $(document).ready(() => {
            fetch("/dashboard-grades-difference", {
                method: "GET"
            }).then((res) => {
                return res.text();
            }).then((res) => {
                const dashboardGradesDifference = JSON.parse(res);

                pieChartData2 = {
                    "labels": ["90-100", "85-89", "80-84", "75-79"],
                    "data": [dashboardGradesDifference.class_a, dashboardGradesDifference.class_b, dashboardGradesDifference.class_c, dashboardGradesDifference.class_d],
                    "colors": ["rgb(49,138,252)", "rgb(30,121,83)", "rgb(30,121,83)", "rgb(30,121,83)"]
                };

                var myPieChart2 = new Chart(document.getElementById('pieChart2'), {
                    type: 'pie',
                    data: {
                        labels: pieChartData2.labels,
                        datasets: [{
                            data: pieChartData2.data,
                            backgroundColor: pieChartData2.colors,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: true,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true
                        },
                        cutoutPercentage: 10,
                    },
                });
            }).catch((error) => {
                console.error("Error fetching data:", error);
            });
        });

        fetch('/dashboard-grades-average')
            .then(response => response.json())
            .then(data => {
                const sectionCount = data.labels.length;
                const colors = Array.from({ length: sectionCount }, (_, i) => `hsl(${(i * 360) / sectionCount}, 70%, 60%)`);

                pieChartData3 = {
                    labels: data.labels,
                    data: data.datasets[0].data,
                    colors: colors
                };

                var myPieChart3 = new Chart(document.getElementById('pieChart3'), {
                    type: 'pie',
                    data: {
                        labels: pieChartData3.labels,
                        datasets: [{
                            data: pieChartData3.data,
                            backgroundColor: pieChartData3.colors,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: true,
                            caretPadding: 10,
                        },
                        legend: {
                            display: true
                        },
                        cutoutPercentage: 10,
                    },
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));

        fetch('/dashboard-section-passing')
            .then(response => response.json())
            .then(data => {
                pieChartData4 = {
                    labels: data.labels,
                    data: data.datasets[0].data,
                    colors: ["rgb(49,138,252)", "rgb(30,121,83)", "rgb(255,206,86)", "rgb(75,192,192)", "rgb(153,102,255)", "rgb(255,159,64)"]
                };

                var myPieChart4 = new Chart(document.getElementById('pieChart4'), {
                    type: 'pie',
                    data: {
                        labels: pieChartData4.labels,
                        datasets: [{
                            data: pieChartData4.data,
                            backgroundColor: pieChartData4.colors,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: true,
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    const label = chart.labels[tooltipItem.index];
                                    const value = chart.datasets[0].data[tooltipItem.index];
                                    return `${label}: ${value}% Passing Rate`;
                                }
                            }
                        },
                        legend: {
                            display: true
                        },
                        cutoutPercentage: 10,
                    },
                });
            })
            .catch(error => console.error('Error fetching passing rate data:', error));

        fetch("/dashboard-section-count")
            .then(response => response.json())
            .then(data => {
                console.log("Data received from backend:", data);

                if (!data.labels || !data.data) {
                    console.error("Unexpected data format:", data);
                    return;
                }

                const colors = data.data.map(() => {
                    return `hsl(${Math.floor(Math.random() * 360)}, 70%, 70%)`;
                });

                new Chart(document.getElementById('sectionCount'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Student Count by Section',
                            data: data.data,
                            backgroundColor: colors,
                            borderColor: colors.map(color => color.replace('70%', '50%')),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
