new Chart(document.getElementById('pageviewsChart'), {
            type: 'doughnut',
            data: {
                labels: ['View', 'Sign up', 'Transaction'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#22c55e', '#3b82f6', '#facc15'],
                    borderColor: '#1e293b',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });



        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'New customer',
                        data: [70, 65, 60, 80, 55, 60, 75, 90, 45, 50, 100, 120],
                        backgroundColor: '#22c55e',
                    },
                    {
                        label: 'Old customer',
                        data: [60, 60, 55, 65, 60, 55, 70, 85, 40, 40, 95, 110],
                        backgroundColor: '#3b82f6',
                    }
                ]
            },
            options: {
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });

        new Chart(document.getElementById('usersChart'), {
            type: 'line',
            data: {
                labels: ['Feb 1', 'Feb 8', 'Feb 15', 'Feb 22', 'Feb 27', 'Feb 32'],
                datasets: [{
                    label: 'Users',
                    data: [500, 1000, 1000, 1500, 3000, 6000],
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: '#3b82f6',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    x: { ticks: { color: 'white' } },
                    y: { ticks: { color: 'white' } }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });

        new Chart(document.getElementById('productsChart'), {
            type: 'bar',
            data: {
                labels: ['Categories'],
                datasets: [
                    {
                        label: 'Graphic Design',
                        data: [6000],
                        backgroundColor: '#22c55e'
                    },
                    {
                        label: 'Marketing',
                        data: [3000],
                        backgroundColor: '#6366f1'
                    },
                    {
                        label: 'Other',
                        data: [1000],
                        backgroundColor: '#94a3b8'
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: { stacked: true, ticks: { color: 'white' } },
                    y: { stacked: true, ticks: { color: 'white' } }
                },
                plugins: {
                    legend: { labels: { color: 'white' } }
                }
            }
        });