<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Welcome to Your Dashboard</h1>
    </div>

    <!-- Dashboard Content: Cards / Widgets -->
    <div class="dashboard-content">
        <div class="card">
            <h3>Total Users</h3>
            <p>
                <?php
                // Sample dynamic content - replace with your real data logic
                $totalUsers = 234; // Example number, can be fetched from a database
                echo $totalUsers;
                ?>
            </p>
        </div>

        <div class="card">
            <h3>Total Sales</h3>
            <p>
                <?php
                // Sample dynamic content - replace with your real data logic
                $totalSales = 14500; // Example number, can be fetched from a database
                echo "$" . number_format($totalSales);
                ?>
            </p>
        </div>

        <div class="card">
            <h3>Support Tickets</h3>
            <p>
                <?php
                // Sample dynamic content - replace with your real data logic
                $tickets = 12; // Example number, can be fetched from a database
                echo $tickets . " Open Tickets";
                ?>
            </p>
        </div>
    </div>

    <!-- Dashboard Footer -->
    <div class="dashboard-footer">
        &copy; <?php echo date('Y'); ?> Your Company. All rights reserved.
    </div>
</div>