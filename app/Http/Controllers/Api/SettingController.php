<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SettingCollection;
use File;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    // public function setting($key){
    //     dd($key, 'sdfasdf');
    //     $result = SettingHelper::setting($key);
    //     return response()->json(['message' => $result]);
    // }

    public function settingFetch(Request $request){
        $result = Setting::whereIn('key', $request->input('keysArray'))->pluck('value','key')->toArray();

        return response()->json($result);
    }

    public function alumniHomeUpdate(Request $request) {
        $this->validate($request, [
            'welcome' => 'nullable|string',
            'featureAlumniTitle' => 'nullable|string',
            'featureAlumniSubTitle' => 'nullable|string',
            'newsroomTitle' => 'nullable|string',
            'newsroomSubTitle' => 'nullable|string',
            'latestMemberTitle' => 'nullable|string',
            'latestMemberSubTitle' => 'nullable|string',
            'eventTitle' => 'nullable|string',
            'eventSubTitle' => 'nullable|string',

            'alumniSiteAddress' => 'nullable|string',
            'alumniFooterContactOne' => 'nullable|string',
            'alumniFooterContactTwo' => 'nullable|string',
            'alumniFooterContactThree' => 'nullable|string',
            'alumniFooterSiteEmail' => 'nullable|string',

            'alumniFooterResourcesText' => 'nullable|string',
            'alumniFooterResourcesLinkOneTitle' => 'nullable|string',
            'alumniFooterResourcesLinkOne' => 'nullable|string',
            'alumniFooterResourcesLinkTwoTitle' => 'nullable|string',
            'alumniFooterResourcesLinkTwo' => 'nullable|string',
            // 'alumniFooterResourcesLinkThreeTitle' => 'nullable|string',
            // 'alumniFooterResourcesLinkThree' => 'nullable|string',

            'alumniFooterInformationText' => 'nullable|string',
            'alumniFooterInformationLinkOneTitle' => 'nullable|string',
            'alumniFooterInformationLinkOne' => 'nullable|string',
            'alumniFooterInformationLinkTwoTitle' => 'nullable|string',
            'alumniFooterInformationLinkTwo' => 'nullable|string',
            // 'alumniFooterInformationLinkThreeTitle' => 'nullable|string',
            // 'alumniFooterInformationLinkThree' => 'nullable|string',

            'alumniFooterLocationMapText' => 'nullable|string',

            'alumniFooterQuickLinksOneTitle' => 'nullable|string',
            'alumniFooterQuickLinksOne' => 'nullable|string',
            'alumniFooterQuickLinksTwoTitle' => 'nullable|string',
            'alumniFooterQuickLinksTwo' => 'nullable|string',
            'alumniFooterQuickLinksThreeTitle' => 'nullable|string',
            'alumniFooterQuickLinksThree' => 'nullable|string',
        ]);

        if ($request->headerLogo) {
            $headerLogo = $request->headerLogo;
            $directory = 'uploads/images/alumnis/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($headerLogo, 0, strpos($headerLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $header_logo_parts = explode(";base64,", $headerLogo);
            $header_logo_base64 = base64_decode($header_logo_parts[1]);
            file_put_contents($path, $header_logo_base64);

            Setting::updateOrCreate(['key' => 'headerLogo'],['value' => URL::to($path)]);
        }

        Setting::updateOrCreate(['key' => 'welcomeTitle'], ['value' => $request->get('welcomeTitle')]);
        Setting::updateOrCreate(['key' => 'featureAlumniTitle'], ['value' => $request->get('featureAlumniTitle')]);
        Setting::updateOrCreate(['key' => 'featureAlumniSubTitle'], ['value' => $request->get('featureAlumniSubTitle')]);
        Setting::updateOrCreate(['key' => 'newsroomTitle'], ['value' => $request->get('newsroomTitle')]);
        Setting::updateOrCreate(['key' => 'newsroomSubTitle'], ['value' => $request->get('newsroomSubTitle')]);
        Setting::updateOrCreate(['key' => 'latestMemberTitle'], ['value' => $request->get('latestMemberTitle')]);
        Setting::updateOrCreate(['key' => 'latestMemberSubTitle'], ['value' => $request->get('latestMemberSubTitle')]);
        Setting::updateOrCreate(['key' => 'eventTitle'], ['value' => $request->get('eventTitle')]);
        Setting::updateOrCreate(['key' => 'eventSubTitle'], ['value' => $request->get('eventSubTitle')]);

        if ($request->footerLogo) {
            $footerLogo = $request->footerLogo;
            $directory = 'uploads/images/alumnis/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($footerLogo, 0, strpos($footerLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $footer_logo_parts = explode(";base64,", $footerLogo);
            $footer_logo_base64 = base64_decode($footer_logo_parts[1]);
            file_put_contents($path, $footer_logo_base64);

            Setting::updateOrCreate(['key' => 'footerLogo'], ['value' => URL::to($path)]);
        }

        Setting::updateOrCreate(['key' => 'alumniSiteAddress'], ['value' => $request->get('alumniSiteAddress')]);
        Setting::updateOrCreate(['key' => 'alumniFooterContactOne'], ['value' => $request->get('alumniFooterContactOne')]);
        Setting::updateOrCreate(['key' => 'alumniFooterContactTwo'], ['value' => $request->get('alumniFooterContactTwo')]);
        Setting::updateOrCreate(['key' => 'alumniFooterContactThree'], ['value' => $request->get('alumniFooterContactThree')]);
        Setting::updateOrCreate(['key' => 'alumniFooterSiteEmail'], ['value' => $request->get('alumniFooterSiteEmail')]);

        Setting::updateOrCreate(['key' => 'alumniFooterResourcesText'], ['value' => $request->get('alumniFooterResourcesText')]);
        Setting::updateOrCreate(['key' => 'alumniFooterResourcesLinkOneTitle'], ['value' => $request->get('alumniFooterResourcesLinkOneTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterResourcesLinkOne'], ['value' => $request->get('alumniFooterResourcesLinkOne')]);
        Setting::updateOrCreate(['key' => 'alumniFooterResourcesLinkTwoTitle'], ['value' => $request->get('alumniFooterResourcesLinkTwoTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterResourcesLinkTwo'], ['value' => $request->get('alumniFooterResourcesLinkTwo')]);
        // Setting::updateOrCreate(['key' => 'alumniFooterResourcesLinkThreeTitle'], ['value' => $request->get('alumniFooterResourcesLinkThree')]);
        // Setting::updateOrCreate(['key' => 'alumniFooterResourcesLinkThree'], ['value' => $request->get('alumniFooterResourcesLinkThree')]);

        Setting::updateOrCreate(['key' => 'alumniFooterInformationText'], ['value' => $request->get('alumniFooterInformationText')]);
        Setting::updateOrCreate(['key' => 'alumniFooterInformationLinkOneTitle'], ['value' => $request->get('alumniFooterInformationLinkOneTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterInformationLinkOne'], ['value' => $request->get('alumniFooterInformationLinkOne')]);
        Setting::updateOrCreate(['key' => 'alumniFooterInformationLinkTwoTitle'], ['value' => $request->get('alumniFooterInformationLinkTwoTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterInformationLinkTwo'], ['value' => $request->get('alumniFooterInformationLinkTwo')]);
        // Setting::updateOrCreate(['key' => 'alumniFooterInformationLinkThreeTitle'], ['value' => $request->get('alumniFooterInformationLinkThree')]);
        // Setting::updateOrCreate(['key' => 'alumniFooterInformationLinkThree'], ['value' => $request->get('alumniFooterInformationLinkThree')]);

        Setting::updateOrCreate(['key' => 'alumniFooterLocationMapText'], ['value' => $request->get('alumniFooterLocationMapText')]);

        Setting::updateOrCreate(['key' => 'alumniFooterQuickLinksOneTitle'], ['value' => $request->get('alumniFooterQuickLinksOneTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterQuickLinksOne'], ['value' => $request->get('alumniFooterQuickLinksOne')]);
        Setting::updateOrCreate(['key' => 'alumniFooterQuickLinksTwoTitle'], ['value' => $request->get('alumniFooterQuickLinksTwoTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterQuickLinksTwo'], ['value' => $request->get('alumniFooterQuickLinksTwo')]);
        Setting::updateOrCreate(['key' => 'alumniFooterQuickLinksThreeTitle'], ['value' => $request->get('alumniFooterQuickLinksThreeTitle')]);
        Setting::updateOrCreate(['key' => 'alumniFooterQuickLinksThree'], ['value' => $request->get('alumniFooterQuickLinksThree')]);

        return response()->json([
            'message' => 'Alumni home site content updated'
        ]);
    }

    public function alumniDashboardUpdate(Request $request) {
        if ($request->alumniDashboardHeaderLogo) {
            $alumniDashboardHeaderLogo = $request->alumniDashboardHeaderLogo;
            $directory = 'uploads/images/alumnis/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($alumniDashboardHeaderLogo, 0, strpos($alumniDashboardHeaderLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $header_logo_parts = explode(";base64,", $alumniDashboardHeaderLogo);
            $header_logo_base64 = base64_decode($header_logo_parts[1]);
            file_put_contents($path, $header_logo_base64);

            Setting::updateOrCreate(['key' => 'alumniDashboardHeaderLogo'],['value' => URL::to($path)]);
        }

        return response()->json([
            'message' => 'Alumni dashboard site content updated'
        ]);

    }

    public function cccHomeUpdate(Request $request)
    {
        $this->validate($request, [
            'whoWeAreTitle' => 'nullable|string',
            'cccTalkToOurTeamTitle' => 'nullable|string',
            'cccTalkToOurTeamSubTitle' => 'nullable|string',
            'cccNewsTitle' => 'nullable|string',
            'cccNewsSubTitle' => 'nullable|string',
            'NoticeEventsTitle' => 'nullable|string',
            'NoticeEventsSubTitle' => 'nullable|string',
            'recentPlacementTitle' => 'nullable|string',
            'recentPlacementSubTitle' => 'nullable|string',
            'careerTipsAndTricksTitle' => 'nullable|string',
            'careerTipsAndTricksSubTitle' => 'nullable|string',
            'resourcesTitle' => 'nullable|string',
            'resourcesSubTitle' => 'nullable|string',
            'successfullyPlacedStudentTitle' => 'nullable|string',
            'successfullyPlacedStudentSubTitle' => 'nullable|string',

            'cccSiteAddress' => 'nullable|string',
            'cccFooterContactOne' => 'nullable|string',
            'cccFooterContactTwo' => 'nullable|string',
            'cccFooterContactThree' => 'nullable|string',
            'cccFooterSiteEmail' => 'nullable|string',

            'cccFooterSecoundColTitle' => 'nullable|string',
            'cccFooterSecoundColLinkOneTitle' => 'nullable|string',
            'cccFooterSecoundColLinkOne' => 'nullable|string',
            'cccFooterSecoundColLinkTwoTitle' => 'nullable|string',
            'cccFooterSecoundColLinkTwo' => 'nullable|string',
            'cccFooterSecoundColLinkThreeTitle' => 'nullable|string',
            'cccFooterSecoundColLinkThree' => 'nullable|string',

            'cccFooterThirdColTitle' => 'nullable|string',
            'cccFooterThirdColLinkOneTitle' => 'nullable|string',
            'cccFooterThirdColLinkOne' => 'nullable|string',
            'cccFooterThirdColLinkTwoTitle' => 'nullable|string',
            'cccFooterThirdColLinkTwo' => 'nullable|string',
            'cccFooterThirdColLinkThreeTitle' => 'nullable|string',
            'cccFooterThirdColLinkThree' => 'nullable|string',

            'cccFooterFourthColTitle' => 'nullable|string',

            'cccFooterQuickLinksOneTitle' => 'nullable|string',
            'cccFooterQuickLinksOne' => 'nullable|string',
            'cccFooterQuickLinksTwoTitle' => 'nullable|string',
            'cccFooterQuickLinksTwo' => 'nullable|string',
            'cccFooterQuickLinksThreeTitle' => 'nullable|string',
            'cccFooterQuickLinksThree' => 'nullable|string',
        ]);

        if ($request->cccHeaderLogo) {
            $cccHeaderLogo = $request->cccHeaderLogo;
            $directory = 'uploads/images/ccc/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($cccHeaderLogo, 0, strpos($cccHeaderLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $ccc_header_logo_parts = explode(";base64,", $cccHeaderLogo);
            $ccc_header_logo_base64 = base64_decode($ccc_header_logo_parts[1]);
            file_put_contents($path, $ccc_header_logo_base64);

            Setting::updateOrCreate(['key' => 'cccHeaderLogo'], ['value' => URL::to($path)]);
        }

        if ($request->cccTalkToOurTeamImage) {
            $cccTalkToOurTeamImage = $request->cccTalkToOurTeamImage;
            $directory = 'uploads/images/ccc/talkToOurTeamBg';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($cccTalkToOurTeamImage, 0, strpos($cccTalkToOurTeamImage, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $ccc_talk_to_our_team_image_parts = explode(";base64,", $cccTalkToOurTeamImage);
            $ccc_talk_to_our_team_image_base64 = base64_decode($ccc_talk_to_our_team_image_parts[1]);
            file_put_contents($path, $ccc_talk_to_our_team_image_base64);

            Setting::updateOrCreate(['key' => 'cccTalkToOurTeamImage'], ['value' => URL::to($path)]);
        }

        Setting::updateOrCreate(['key' => 'whoWeAreTitle'], ['value' => $request->get('whoWeAreTitle')]);
        Setting::updateOrCreate(['key' => 'cccTalkToOurTeamTitle'], ['value' => $request->get('cccTalkToOurTeamTitle')]);
        Setting::updateOrCreate(['key' => 'cccTalkToOurTeamSubTitle'], ['value' => $request->get('cccTalkToOurTeamSubTitle')]);
        Setting::updateOrCreate(['key' => 'cccNewsTitle'], ['value' => $request->get('cccNewsTitle')]);
        Setting::updateOrCreate(['key' => 'cccNewsSubTitle'], ['value' => $request->get('cccNewsSubTitle')]);
        Setting::updateOrCreate(['key' => 'NoticeEventsTitle'], ['value' => $request->get('NoticeEventsTitle')]);
        Setting::updateOrCreate(['key' => 'NoticeEventsSubTitle'], ['value' => $request->get('NoticeEventsSubTitle')]);
        Setting::updateOrCreate(['key' => 'recentPlacementTitle'], ['value' => $request->get('recentPlacementTitle')]);
        Setting::updateOrCreate(['key' => 'recentPlacementSubTitle'], ['value' => $request->get('recentPlacementSubTitle')]);
        Setting::updateOrCreate(['key' => 'careerTipsAndTricksTitle'], ['value' => $request->get('careerTipsAndTricksTitle')]);
        Setting::updateOrCreate(['key' => 'careerTipsAndTricksSubTitle'], ['value' => $request->get('careerTipsAndTricksSubTitle')]);
        Setting::updateOrCreate(['key' => 'resourcesTitle'], ['value' => $request->get('resourcesTitle')]);
        Setting::updateOrCreate(['key' => 'resourcesSubTitle'], ['value' => $request->get('resourcesSubTitle')]);
        Setting::updateOrCreate(['key' => 'successfullyPlacedStudentTitle'], ['value' => $request->get('successfullyPlacedStudentTitle')]);
        Setting::updateOrCreate(['key' => 'successfullyPlacedStudentSubTitle'], ['value' => $request->get('successfullyPlacedStudentSubTitle')]);



        if ($request->cccFooterLogo) {
            $cccFooterLogo = $request->cccFooterLogo;
            $directory = 'uploads/images/ccc/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($cccFooterLogo, 0, strpos($cccFooterLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $ccc_footer_logo_parts = explode(";base64,", $cccFooterLogo);
            $ccc_footer_logo_base64 = base64_decode($ccc_footer_logo_parts[1]);
            file_put_contents($path, $ccc_footer_logo_base64);

            Setting::updateOrCreate(['key' => 'cccFooterLogo'], ['value' => URL::to($path)]);
        }

        Setting::updateOrCreate(['key' => 'cccSiteAddress'], ['value' => $request->get('cccSiteAddress')]);
        Setting::updateOrCreate(['key' => 'cccFooterContactOne'], ['value' => $request->get('cccFooterContactOne')]);
        Setting::updateOrCreate(['key' => 'cccFooterContactTwo'], ['value' => $request->get('cccFooterContactTwo')]);
        Setting::updateOrCreate(['key' => 'cccFooterContactThree'], ['value' => $request->get('cccFooterContactThree')]);
        Setting::updateOrCreate(['key' => 'cccFooterSiteEmail'], ['value' => $request->get('cccFooterSiteEmail')]);

        Setting::updateOrCreate(['key' => 'cccFooterSecoundColTitle'], ['value' => $request->get('cccFooterSecoundColTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterSecoundColLinkOneTitle'], ['value' => $request->get('cccFooterSecoundColLinkOneTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterSecoundColLinkOne'], ['value' => $request->get('cccFooterSecoundColLinkOne')]);
        Setting::updateOrCreate(['key' => 'cccFooterSecoundColLinkTwoTitle'], ['value' => $request->get('cccFooterSecoundColLinkTwoTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterSecoundColLinkTwo'], ['value' => $request->get('cccFooterSecoundColLinkTwo')]);
        Setting::updateOrCreate(['key' => 'cccFooterSecoundColLinkThreeTitle'], ['value' => $request->get('cccFooterSecoundColLinkThreeTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterSecoundColLinkThree'], ['value' => $request->get('cccFooterSecoundColLinkThree')]);

        Setting::updateOrCreate(['key' => 'cccFooterThirdColTitle'], ['value' => $request->get('cccFooterThirdColTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterThirdColLinkOneTitle'], ['value' => $request->get('cccFooterThirdColLinkOneTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterThirdColLinkOne'], ['value' => $request->get('cccFooterThirdColLinkOne')]);
        Setting::updateOrCreate(['key' => 'cccFooterThirdColLinkTwoTitle'], ['value' => $request->get('cccFooterThirdColLinkTwoTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterThirdColLinkTwo'], ['value' => $request->get('cccFooterThirdColLinkTwo')]);
        Setting::updateOrCreate(['key' => 'cccFooterThirdColLinkThreeTitle'], ['value' => $request->get('cccFooterThirdColLinkThreeTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterThirdColLinkThree'], ['value' => $request->get('cccFooterThirdColLinkThree')]);

        Setting::updateOrCreate(['key' => 'cccFooterFourthColTitle'], ['value' => $request->get('cccFooterFourthColTitle')]);

        Setting::updateOrCreate(['key' => 'cccFooterQuickLinksOneTitle'], ['value' => $request->get('cccFooterQuickLinksOneTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterQuickLinksOne'], ['value' => $request->get('cccFooterQuickLinksOne')]);
        Setting::updateOrCreate(['key' => 'cccFooterQuickLinksTwoTitle'], ['value' => $request->get('cccFooterQuickLinksTwoTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterQuickLinksTwo'], ['value' => $request->get('cccFooterQuickLinksTwo')]);
        Setting::updateOrCreate(['key' => 'cccFooterQuickLinksThreeTitle'], ['value' => $request->get('cccFooterQuickLinksThreeTitle')]);
        Setting::updateOrCreate(['key' => 'cccFooterQuickLinksThree'], ['value' => $request->get('cccFooterQuickLinksThree')]);

        return response()->json([
            'message' => 'CCC home site content updated'
        ]);
    }

    public function jobPortalHomeUpdate(Request $request)
    {
        $this->validate($request, [
            'jobPortalSiteAddress' => 'nullable|string',
            'jobPortalFooterContactOne' => 'nullable|string',
            'jobPortalFooterContactTwo' => 'nullable|string',
            'jobPortalFooterContactThree' => 'nullable|string',
            'jobPortalFooterSiteEmail' => 'nullable|string',
            'jobPortalFooterStudentText' => 'nullable|string',
            'jobPortalFooterOurCampusText' => 'nullable|string',
            'jobPortalFooterLocationMapText' => 'nullable|string',
            'jobPortalFooterQuickLinksOneTitle' => 'nullable|string',
            'jobPortalFooterQuickLinksOne' => 'nullable|string',
            'jobPortalFooterQuickLinksTwoTitle' => 'nullable|string',
            'jobPortalFooterQuickLinksTwo' => 'nullable|string',
            'jobPortalFooterQuickLinksThreeTitle' => 'nullable|string',
            'jobPortalFooterQuickLinksThree' => 'nullable|string',
        ]);

        if ($request->jobPortalHeaderLogo) {
            $jobPortalHeaderLogo = $request->jobPortalHeaderLogo;
            $directory = 'uploads/images/job_portal/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($jobPortalHeaderLogo, 0, strpos($jobPortalHeaderLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $job_portal_header_logo_parts = explode(";base64,", $jobPortalHeaderLogo);
            $job_portal_header_logo_base64 = base64_decode($job_portal_header_logo_parts[1]);
            file_put_contents($path, $job_portal_header_logo_base64);

            Setting::updateOrCreate(['key' => 'jobPortalHeaderLogo'], ['value' => URL::to($path)]);
        }

        if ($request->jobPortalFooterLogo) {
            $jobPortalFooterLogo = $request->jobPortalFooterLogo;
            $directory = 'uploads/images/job_portal/logos';
            $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($jobPortalFooterLogo, 0, strpos($jobPortalFooterLogo, ';')))[1])[1];
            $path = $directory . '/' . $filename;

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0775, true, true);
            }

            $job_portal_footer_logo_parts = explode(";base64,", $jobPortalFooterLogo);
            $job_portal_footer_logo_base64 = base64_decode($job_portal_footer_logo_parts[1]);
            file_put_contents($path, $job_portal_footer_logo_base64);

            Setting::updateOrCreate(['key' => 'jobPortalFooterLogo'], ['value' => URL::to($path)]);
        }

        Setting::updateOrCreate(['key' => 'jobPortalSiteAddress'], ['value' => $request->get('jobPortalSiteAddress')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterContactOne'], ['value' => $request->get('jobPortalFooterContactOne')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterContactTwo'], ['value' => $request->get('jobPortalFooterContactTwo')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterContactThree'], ['value' => $request->get('jobPortalFooterContactThree')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterSiteEmail'], ['value' => $request->get('jobPortalFooterSiteEmail')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterStudentText'], ['value' => $request->get('jobPortalFooterStudentText')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterOurCampusText'], ['value' => $request->get('jobPortalFooterOurCampusText')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterLocationMapText'], ['value' => $request->get('jobPortalFooterLocationMapText')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterQuickLinksOneTitle'], ['value' => $request->get('jobPortalFooterQuickLinksOneTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterQuickLinksOne'], ['value' => $request->get('jobPortalFooterQuickLinksOne')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterQuickLinksTwoTitle'], ['value' => $request->get('jobPortalFooterQuickLinksTwoTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterQuickLinksTwo'], ['value' => $request->get('jobPortalFooterQuickLinksTwo')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterQuickLinksThreeTitle'], ['value' => $request->get('jobPortalFooterQuickLinksThreeTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterQuickLinksThree'], ['value' => $request->get('jobPortalFooterQuickLinksThree')]);


        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesText'], ['value' => $request->get('jobPortalFooterResourcesText')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkOneTitle'], ['value' => $request->get('jobPortalFooterResourcesLinkOneTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkOne'], ['value' => $request->get('jobPortalFooterResourcesLinkOne')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkTwoTitle'], ['value' => $request->get('jobPortalFooterResourcesLinkTwoTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkTwo'], ['value' => $request->get('jobPortalFooterResourcesLinkTwo')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkThreeTitle'], ['value' => $request->get('jobPortalFooterResourcesLinkThreeTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkThree'], ['value' => $request->get('jobPortalFooterResourcesLinkThree')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkForeTitle'], ['value' => $request->get('jobPortalFooterResourcesLinkForeTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterResourcesLinkFore'], ['value' => $request->get('jobPortalFooterResourcesLinkFore')]);


        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationText'], ['value' => $request->get('jobPortalFooterInformationText')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkOneTitle'], ['value' => $request->get('jobPortalFooterInformationLinkOneTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkOne'], ['value' => $request->get('jobPortalFooterInformationLinkOne')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkTwoTitle'], ['value' => $request->get('jobPortalFooterInformationLinkTwoTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkTwo'], ['value' => $request->get('jobPortalFooterInformationLinkTwo')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkThreeTitle'], ['value' => $request->get('jobPortalFooterInformationLinkThreeTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkThree'], ['value' => $request->get('jobPortalFooterInformationLinkThree')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkForeTitle'], ['value' => $request->get('jobPortalFooterInformationLinkForeTitle')]);
        Setting::updateOrCreate(['key' => 'jobPortalFooterInformationLinkFore'], ['value' => $request->get('jobPortalFooterInformationLinkFore')]);


        return response()->json([
            'message' => 'Job Portal home site content updated'
        ]);
    }

    public function jobPortalDashboardUpdate(Request $request)
    {
        $this->validate($request, [
            'searchJobTitle' => 'nullable|string',
        ]);

        Setting::updateOrCreate(['key' => 'searchJobTitle'], ['value' => $request->get('searchJobTitle')]);

        return response()->json([
            'message' => 'Job Portal dashboard site content updated'
        ]);
    }

    public function settingSection()
    {
        if (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Setting::query()
                ->where('key', 'LIKE', '%' . 'sec_' . '%')
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new SettingCollection($query);

        } elseif(request()->siteFrom == 'ccc-home'){

            $query = Setting::query()->where('key', 'LIKE', '%' . 'sec_ccc_home_' . '%')->pluck('value','key')->toArray();
            return response()->json($query);

        } elseif(request()->siteFrom == 'alumni-home'){

            $query = Setting::query()->where('key', 'LIKE', '%' . 'sec_alumni_home_' . '%')->pluck('value','key')->toArray();
            return response()->json($query);

        }

    }

    public function settingStore(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);

        Setting::query()->updateOrCreate(['key' => $request->key], ['value' => $request->value]);

        return response()->json([
            'message' => 'Section content Hide/Show condition Applied Successfully'
        ]);
    }


}
