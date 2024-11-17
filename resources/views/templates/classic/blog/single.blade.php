@extends($activeTheme.'layouts.main')
@section('title', $blog->title)
@section('description', $blog->short_description)
@section('og_image', asset('storage/blog/'.$blog->image))
@section('content')
    <section class="blog-single pb-120">
        <!-- / # START * Single Post / Blog Detail Header * START -->
        <div class="theme-gradient-3 pt-70">
            <div class="container pt-70 pb-160 md-pt-32 md-pb-150 text-center">
                <div class="row wow fadeInUp" data-wow-delay="300ms">
                    <div class="col-md-10 col-xl-8 mx-auto">
                        <div class="post-header">
                            <div class="post-category mb-5">
                                <a href="{{ route('blog.category', $blog->blogCategory->slug) }}" class="text-decoration -underline text-primary" rel="category">{{ $blog->blogCategory->name }}</a>
                            </div>
                            <!-- /.post-category -->
                            <h1 class="mb-16">{{ $blog->title }}</h1>
                            <ul class="post-meta mb-5 text-grey-2">
                                <li class="post-date"><i class="fa-regular fa-calendar-alt"></i><span>{{ date_formating($blog->created_at) }}</span></li>
                                <li class="post-author"><i class="fa-regular fa-user"></i><span>{{ ___('By') }} {{ $blog->user->name }}</span></li>
                                @if (@$settings->blog->commenting)
                                <li class="post-comments"><a href="#blog-comments"><i class="fa-regular fa-comment"></i>{{ $blogComments->count() }}<span> {{ ___('Comments') }}</span></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / #  END * Single Post / Blog Detail Header * END -->

        <!-- / #  START * Single Post / Blog Detail Image * START *-->
        <div class="container">
            <div class="mx-auto wow fadeInUp mt-n100" data-wow-delay="300ms">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog-image"><img class="w-100 h-auto rounded-3" src="{{ asset('storage/blog/'.$blog->image) }}" alt="{{ $blog->title }}"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / #  END * Single Post / Blog Detail Image * END *-->

        <!-- / #  START * Single Post / Blog Detail Content * START *-->
        <div class="container">
            <div class="row wow fadeInUp">
                <div class="col-xl-8 offset-xl-2">
                    <div class="post-content mt-45 mb-60">
                        {!! $blog->content !!}
                    </div>
                    <div class="separator-1px-op-l"></div>

                    <!-- / #  START * Social Share And Single Post Tags * START *-->
                    <div class="d-block d-sm-flex justify-content-between pt-50 sm-pt-30 pb-50 sm-pb-30">
                        <div class="d-flex align-items-center sm-mb-10">
                            <span class="me-2">{{ ___('Share this post') }}</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="icon-group"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?text={{ url()->current() }}" target="_blank" class="icon-group"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" target="_blank" class="icon-group"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://wa.me/?text={{ url()->current() }}" target="_blank" class="icon-group"><i class="fab fa-whatsapp"></i></a>
                            <a href="http://pinterest.com/pin/create/button/?url={{ url()->current() }}" target="_blank" class="icon-group"><i class="fab fa-pinterest"></i></a>
                        </div>
                        @if(!empty($blog->tags))
                            <div class="single-post-tag d-flex">
                                @foreach($blog->tags as $tag)
                                    @if(!empty(trim($tag)))
                                        <a class="mr-10"
                                           href="{{ route('blog.tag', trim($tag)) }}">{{ trim($tag) }}</a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <!-- / #  END * Social Share And Single Post Tags * END *-->

                    <div class="separator-1px-op-l"></div>

                    <!-- / #  START * Blog previous and next pagination * START *-->
                    <div class="blog-pagination">
                        <div class="row justify-content-between pt-45 sm-pt-30 pb-45 sm-pb-30">
                            <div class="col-md-6">
                                @if ($previous_record != null)
                                <div class="pag_prev">
                                    <a href="{{ route('blog.article', $previous_record->slug) }}">
                                        <h5><span class="fas fa-chevron-left pe-2"></span> {{ ___('Previous Post') }}</h5>
                                        <p class="font-14 text mb-0">{{ $previous_record->title }}</p>
                                    </a>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                @if ($next_record != null)
                                <div class="pag_next">
                                    <a href="{{ route('blog.article', $next_record->slug) }}" class="text-end">
                                        <h5>{{ ___('Next Post') }}<span class="fas fa-chevron-right ps-2"></span></h5>
                                        <p class="font-14 text mb-0">{{ $next_record->title }}</p>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- / #  END * Blog previous and next pagination * END *-->

                    <div class="separator-1px-op-l"></div>

                    @if (@$settings->blog->commenting)

                    <!-- / #  START * All Comments * START *-->
                    <div class="mb-50">
                        <div class="pagination-comments" id="blog-comments">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="total-review d-flex align-items-center justify-content-between mb-20 mt-60">
                                        <h4 class="mb-15">
                                            <i class="far fa-comments me-2"></i>
                                            {{ $blogComments->count() }} {{ ___('Comments') }}
                                        </h4>
                                    </div>
                                </div>
                                @forelse ($blogComments as $blogComment)
                                    <div class="col-md-12">
                                        <div class="position-relative d-flex align-items-center justify-content-start sm-mb-30">
                                            <img src="{{ asset('storage/users/'.$blogComment->user->avatar) }}"
                                                 alt="{{ $blogComment->user->name }}" class="mr-4 size-60 rounded-circle">
                                            <div class="ml-20">
                                                <h6 class="mt-0 mb-0">{{ $blogComment->user->name }}</h6>
                                                <div><span class="font-14">{{ datetime_formating($blogComment->created_at) }}</span></div>
                                            </div>
                                        </div>
                                        <p class="mt-20 mb-20">{!! nl2br($blogComment->comment) !!}</p>
                                    </div>
                                @empty
                                    <span class="text-muted mb-10">{{ ___('No comments found') }}</span>
                                @endforelse
                                <div class="separator-1px-op-l"></div>
                            </div>
                        </div>
                    </div>
                    <!-- / #  END * All Comments * END *-->

                    <!-- / #  START * Add Comment Form* START *-->
                    <div class="post-review">
                        <h6 class="font-18">{{ ___('Leave a comment') }}</h6>
                        @auth
                            <form action="{{ route('blog.article', $blog->slug) }}" method="POST" class="mt-30">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-24">
                                            <label class="mb-2">{{ ___('Comment') }}</label>
                                            <textarea name="comment" class="pt-15 form-control text-field" rows="6" placeholder="{{ ___('Your comment') }}" required></textarea>
                                        </div>
                                    </div>
                                    {!! display_captcha() !!}
                                    <div class="col-md-12">
                                        <button class="button -lg -primary push-right">{{ ___('Publish') }}<i class="ml-5 fal fa-arrow-right-long push-this"></i></button>
                                    </div>
                                </div>
                            </form>

                        @else
                            <div class="card text-center">
                                <p>{{ ___('You need to login to post a comment.') }}</p>
                            </div>
                        @endauth
                    </div>
                    <!-- / #  END * Add Comment Form * END *-->
                        @endif

                </div>
            </div>
        </div>
        <!-- / #  START * Single Post / Blog Detail Content * START *-->
    </section>

    @push('scripts_at_bottom')
        {!! google_captcha() !!}
    @endpush
@endsection
