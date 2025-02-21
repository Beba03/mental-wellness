<?php
    include("headerlogic.php");
    include("Header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Wellness</title>
    <link rel="stylesheet" href="../CSS/landing.css">
</head>

<body>
    <div class="main-content">
        <div class="content-left">
            <h2>Welcome, <?php 
                if ($isLoggedIn) {
                    echo htmlspecialchars($_SESSION['name']);
                } else {
                    echo "User";
                }
                ?></h2>
            <p>Mental wellness is an essential part of overall health. It involves finding balance in life, managing stress, and developing resilience. Our platform provides tools and resources to help you track your mood, access support, and learn strategies for maintaining mental well-being.</p>
            <p>Explore our self-help resources to find articles and guides on managing stress, understanding anxiety, and building emotional resilience. Whether you're looking to improve your sleep or seeking professional therapy, we are here to support you on your journey to mental wellness.</p>
        </div>
        <div class="content-right">
            <h3>Mood Tracker</h3>
            <div class="calendar">
                <div>1</div><div>2</div><div>3</div><div>4</div><div>5</div><div>6</div><div>7</div>
                <div>8</div><div>9</div><div>10</div><div>11</div><div>12</div><div>13</div><div>14</div>
                <div>15</div><div>16</div><div>17</div><div>18</div><div>19</div><div>20</div><div>21</div>
                <div>22</div><div>23</div><div>24</div><div>25</div><div>26</div><div>27</div><div>28</div>
                <div>29</div><div>30</div><div>31</div>
            </div>
            <div class="legend">
                <p>H = Happy &nbsp; N = Neutral &nbsp; S = Sad</p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    include("..\HTML\Footer.html");
?>