@extends('layout.app')

@section('title', 'Complaint')
@section('bodyClass', 'fixed-header menu-pin menu-behind')

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Complaint
    </h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Complaint</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- ROW-1 -->
<!-- Row -->
<div class="row">
    <div class="col-xl-3">
        <div class="card">
            @include('app.complaint.home.menu')
        </div>
    </div>
    <div class="col-xl-9">
        <div class="card">
            <div class="card-body p-6">
                <div class="inbox-body">
                    <div class="mail-option">
                        <div class="chk-all">
                            <div class="btn-group">
                                <a data-bs-toggle="dropdown" href="#" class="btn mini all" aria-expanded="false">
                                        All
                                        <i class="fa fa-angle-down "></i>
                                    </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"> None</a></li>
                                    <li><a href="#"> Read</a></li>
                                    <li><a href="#"> Unread</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="#" class="btn mini tooltips">
                                <i class=" fa fa-refresh"></i>
                            </a>
                        </div>
                        <div class="btn-group hidden-phone">
                            <a data-bs-toggle="dropdown" href="#" class="btn mini blue" aria-expanded="false">
                                    More
                                    <i class="fa fa-angle-down "></i>
                                </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-pencil me-2"></i> Mark as Read</a></li>
                                <li><a href="#"><i class="fa fa-ban me-2"></i> Spam</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="fa fa-trash-o me-2"></i> Delete</a></li>
                            </ul>
                        </div>
                        <ul class="unstyled inbox-pagination">
                            <li><span class="fs-13">1-50 of 234</span></li>

                            <li>
                                <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-inbox table-hover text-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Tim Reid, S P N</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Boost Your Website Traffic</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>April 01</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                        </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Freelancer.com</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Stop wasting your visitors</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>May 23</td>
                                </tr>
                                <tr class="unread">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark text-danger"></i></td>
                                    <td class="view-message  dont-show clickable-row" data-href='email-read.html'>PHPClass</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Added a new class: Login Class Fast Site</td>
                                    <td class="view-message  text-end clickable-row" data-href='email-read.html'>9:27 AM</td>
                                </tr>

                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Facebook</td>
                                    <td class="view-message view-message clickable-row" data-href='email-read.html'>Somebody requested a new password </td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>June 13</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Skype</td>
                                    <td class="view-message view-message clickable-row" data-href='email-read.html'>Password successfully changed</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 24</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Google+</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>alireza, do you know</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 09</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>WOW Slider </td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>New WOW Slider v7.8 - 67% off</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 14</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>LinkedIn Pulse</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>The One Sign Your Co-Worker Will Stab</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>Feb 19</td>
                                </tr>
                                <tr class="unread">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Google Webmaster </td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Improve the search presence of WebSite</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 15</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>JW Player</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Last Chance: Upgrade to Pro for </td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 15</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Drupal Community</td>
                                    <td class="view-message view-message clickable-row" data-href='email-read.html'>Welcome to the Drupal Community</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 04</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="dont-show fw-semibold clickable-row" data-href='email-read.html'>Zoosk </td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>7 new singles we think you'll like</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>May 14</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark text-danger"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>LinkedIn </td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Alireza: Nokia Networks, System Group and </td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>February 25</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="dont-show fw-semibold clickable-row" data-href='email-read.html'>Facebook</td>
                                    <td class="view-message view-message clickable-row" data-href='email-read.html'>Your account was recently logged into</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>March 14</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Twitter</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Your Twitter password has been changed</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>April 07</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>InternetSeer</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Performance Report</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>July 14</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark text-danger"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Bertina </td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>IMPORTANT: Don't lose your domains!</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>June 16</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark text-danger"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Laura Gaffin, S P N </td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Your Website On Google (Higher Rankings Are Better)</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>August 10</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Facebook</td>
                                    <td class="view-message view-message clickable-row" data-href='email-read.html'>Alireza Zare Login faild</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>feb 14</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>AddMe.com</td>
                                    <td class="view-message clickable-row" data-href='email-read.html'>Submit Your Website to the AddMe Business Directory</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>August 10</td>
                                </tr>
                                <tr class="">
                                    <td class="inbox-small-cells">
                                        <label class="custom-control custom-checkbox mb-0 ms-3">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                            </label>
                                    </td>
                                    <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                    <td class="inbox-small-cells"><i class="fa fa-bookmark"></i></td>
                                    <td class="view-message dont-show fw-semibold clickable-row" data-href='email-read.html'>Terri Rexer, S P N</td>
                                    <td class="view-message view-message clickable-row" data-href='email-read.html'>Forget Google AdWords: Un-Limited Clicks fo</td>
                                    <td class="view-message text-end fw-semibold clickable-row" data-href='email-read.html'>April 14</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <ul class="pagination mb-4">
            <li class="page-item page-prev disabled">
                <a class="page-link" href="#" tabindex="-1">Prev</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item page-next">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </div>
</div>
<!-- ROW-1 CLOSED -->
<!-- ROW-1 END -->


</div>


@endsection

@section('script')
@include('app.complaint.home.scripts.index')
@endsection
