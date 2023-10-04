<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-header">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        @if(@$li_1)
                            <li class="breadcrumb-item">
                                <a {{ isset($li_1_link) ? 'class=breadcrumb-link' : ''  }} {{ isset($li_1_link) ? 'href='.$li_1_link.'' : ''  }} >{{ $li_1 }}</a>
                            </li>
                            {{-- @if(isset($title))
                                 <li class="breadcrumb-item active">{{ $title }}</li>
                             @endif--}}
                        @endif
                        @if(isset($li_2))
                            <li class="breadcrumb-item">
                                <a {{ isset($li_2_link) ? 'class=breadcrumb-link' : ''  }} {{ isset($li_2_link) ? 'href='.$li_2_link.'' : ''  }} >{{ $li_2 }}</a>
                            </li>
                        @endif

                        @if(isset($li_3))
                            <li class="breadcrumb-item">
                                <a {{ isset($li_3_link) ? 'class=breadcrumb-link' : ''  }} {{ isset($li_3_link) ? 'href='.$li_3_link.'' : ''  }} >{{ $li_3 }}</a>
                            </li>
                        @endif

                        @if(isset($create_button))
                            <li>
                                {{$create_button}}
                            </li>
                        @endif
                    </ol>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- end page title -->
