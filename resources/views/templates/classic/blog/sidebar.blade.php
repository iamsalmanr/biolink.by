<div class="col-lg-4">
    <div class="blog-sidebar ms-lg-auto">
        <form action="{{ route('blog.index') }}" method="GET">
            <div class="search-input position-relative mb-30">
                <i class="fa-regular fa-search -left"></i>
                <input type="text" name="search" class="form-control rounded-3 font-14 shadow-none border -focus-dark" placeholder="{{ ___('Search') }}" value="{{ request('search') ?? '' }}" required>
            </div>
        </form>
        <div class="sidebar-widget mb-30">
            <h4 class="widget-title">{{ ___('Categories') }}</h4>
            <div class="category-list mt-30">
                @forelse ($blogCategories as $blogCategory)
                    <a href="{{ route('blog.category', $blogCategory->slug) }}" class="d-flex align-items-center justify-content-between">{{ $blogCategory->name }}</a>
                @empty
                    <span class="text-muted">{{ ___('No categories found') }}</span>
                @endforelse
            </div>
        </div>
        <div class="sidebar-widget mb-30">
            <h4 class="widget-title">{{ ___('Recent Posts') }}</h4>
            @forelse ($recentBlogs as $recentBlog)
                <div class="d-flex align-items-center mt-30 mb-20">
                    <div class="flex-shrink-0 overflow-hidden rounded-2">
                        <img width="70" height="70" src="{{ asset('storage/blog/'.$recentBlog->image) }}" alt="{{ $recentBlog->title }}">
                    </div>
                    <div class="flex-shrink-1 ms-3">
                        <h6 class="fw-semibold mb-0"><a href="{{ route('blog.article', $recentBlog->slug) }}">{{ $recentBlog->title }}</a></h6>
                        <p>{{ date_formating($recentBlog->created_at) }}</p>
                    </div>
                </div>
            @empty
                <span class="text-muted text-center">{{ ___('No articles found') }}</span>
            @endforelse
        </div>
        @if(!empty($blogTags))
        <div class="sidebar-widget mb-30 pb-20">
            <h4 class="widget-title">{{ ___('Tags') }}</h4>
            <div class="tag-list mt-30">
                @foreach($blogTags as $tag)
                    @if(!empty(trim($tag)))
                        <a href="{{ route('blog.tag', trim($tag)) }}">{{ trim($tag) }}</a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

