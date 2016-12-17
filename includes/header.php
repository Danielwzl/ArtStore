<?php
include 'includes/sessionStart.php';
include 'includes/popup.php';
if(isset($_GET['isAdd']) && !empty($_GET['isAdd']))
{
    switch($_GET['isAdd'])
    {
        case 'add':
            popup('positive', 'New item added');
            break;
        case 'overlap':
            popup('positive', 'Existing item quantity and detail update!');
            break;
    }
}
?>
<header>
	<div class="ui attached stackable grey inverted  menu">
		<div class="ui container">
			<nav class="right menu">
				<div class="ui simple  dropdown item">
					<i class="user icon"></i> Account <i class="dropdown icon"></i>
					<div class="menu">
						<a class="item"><i class="sign in icon"></i> Login</a> <a
							class="item"><i class="edit icon"></i> Edit Profile</a> <a
							class="item"><i class="globe icon"></i> Choose Language</a> <a
							class="item"><i class="settings icon"></i> Account Settings</a>
					</div>
				</div>
				<a class=" item" href="viewFavorite.php"> <i class="heartbeat icon"></i>
					Favorites&nbsp; <?php echo update('favorite'); ?> 
				</a> <a class=" item" href="viewCart.php"> <i class="shop icon"></i>
					Cart&nbsp;<span id="qtyOfItem"><?php echo update('cart'); ?></span>
				</a>
			</nav>
		</div>
	</div>

	<div class="ui attached stackable borderless huge menu">
		<div class="ui container">
			<h2 class="header item">
				<img src="images/logo5.png" class="ui small image">
			</h2>
			<a class="item" href='index.php'> <i class="home icon"></i> Home
			</a> <a class="item" href='aboutus.php'> <i class="mail icon"></i>
				About Us
			</a> <a class="item" href='#'> <i class="home icon"></i> Blog
			</a>
			<div class="ui simple dropdown item">
				<i class="grid layout icon"></i> Browse <i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href='browse-artists.php'><i class="users icon"></i>
						Artists</a> <a class="item" href='browse-genres.php'><i
						class="theme icon"></i> Genres</a> <a class="item"
						href='browse-paintings.php'><i class="paint brush icon"></i>
						Paintings</a> <a class="item" href='browse-subjects.php'><i
						class="cube icon"></i> Subjects</a> <a class="item"
						href='browse-galleries.php'><i class="university icon"></i> Galleries</a>
				</div>
			</div>
			<div class="right item">
					<div class="ui search">
						<div class="ui mini icon input">
							<input class="prompt" type="text" placeholder="Search ..."
								name="search"> <i class=" search icon"></i>
						</div>
						<div class="results"></div>
					</div>
			</div>

		</div>
	</div>
</header>
