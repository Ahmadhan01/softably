 new Chart(document.getElementById('profitChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'New Profit',
                        data: [70, 65, 60, 80, 55, 60, 75, 90, 45, 50, 100, 120],
                        backgroundColor: '#22c55e',
                    },
                    {
                        label: 'Old Profit',
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

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: ['Feb 1', 'Feb 20', 'Mar 5', 'Apr 10', 'May 1', 'May 17'],
                datasets: [{
                    label: 'Total',
                    data: [0, 55000, 50000, 100000, 150000, 120000],
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

        new Chart(document.getElementById('usersChart'), {
            type: 'line',
            data: {
                labels: ['Feb 1', 'Yesterday', 'Today'],
                datasets: [{
                    label: 'Users',
                    data: [100, 200, 150],
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: '#ff1f1f',
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