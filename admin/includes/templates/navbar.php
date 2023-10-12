<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#"><?php echo lang('HOME_ADMIN');?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang("CATEGORIES")?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang("ITEMS")?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang("MEMBERS")?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang("STATISTICS")?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang("LOGS")?></a>
        </li>
        
      </ul>
      <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Tarek
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Log Out</a></li>
            </ul>
            </li>
        </ul>
    
    </div>
  </div>
</nav>