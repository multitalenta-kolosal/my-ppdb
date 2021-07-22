<li class="nav-item">
    <a href="{{ route('frontend.posts.index') }}" class="nav-link">
        <span class="fas fa-file-alt mr-1"></span> Posts
    </a>
</li>
<li class="nav-item dropdown">
    <a href="#" class="nav-link" data-toggle="dropdown" aria-controls="pages_submenu" aria-expanded="false" aria-label="Toggle pages menu item">
        <span class="nav-link-inner-text">
            <span class="fas fa-file-image mr-1"></span>
            Pages
        </span>
        <span class="fas fa-angle-down nav-link-arrow ml-2"></span>
    </a>
    <ul class="dropdown-menu" id="pages_submenu">
        <li>
            <a class="dropdown-item" href="{{ route('frontend.posts.index') }}">
                <span class="fas fa-file-alt mr-1"></span> Posts
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('frontend.categories.index') }}">
                <span class="fas fa-sitemap mr-1"></span> Categories
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('frontend.tags.index') }}">
                <span class="fas fa-tags mr-1"></span> Tags
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('frontend.comments.index') }}">
                <span class="fas fa-comments mr-1"></span> Comments
            </a>
        </li>
    </ul>
</li>