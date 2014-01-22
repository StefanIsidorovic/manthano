
/* creating our module, mainly for adding $routeProvider which can be added only with config method *
 manthanoApp is root module!!
 */
var manthanoApp = angular.module('manthanoApp', ['ngRoute', 'activityModule','userModule','eventModule','materialModule','proposalModule']);
/* Route setting for templates in our main module */
manthanoApp.config(['$routeProvider', function ($routerProvider){
    $routerProvider.
        // Settings for activity
        when('/activity/:idActivity', {
            templateUrl: '/assets/html_fragments/activityInfo.html',
            controller: 'activityShow'
        }).
        when('/activity/modify/:idActivity',{
            templateUrl: '/assets/html_fragments/activityModify.html',
            controller: 'activityModify'
        }).
        when('/activity/new/:idActivity', {
            templateUrl: '/assets/html_fragments/activityNew.html',
            controller: 'activityNew'
        }).
        when('/event/:idEvent', {
            templateUrl: '/assets/html_fragments/eventInfo.html',
            controller: 'eventShow'
        }).
        when('/event/modify/:idEvent', {
           templateUrl: '/assets/html_fragments/eventModify.html',
           controller: 'eventModify'
        }).
        when('/event/new/:nameActivity/:idActivity',{
            templateUrl: '/assets/html_fragments/eventNew.html',
            controller: 'eventNew'
        }).
        when('/user/:id', {
           templateUrl: '/assets/html_fragments/userInfo.html',
           controller: 'userInfo'
        }).
        when('/user/settings/:id', {
            templateUrl: '/assets/html_fragments/userSettings.html',
            controller: 'userSettings'
        }).
        when('/proposal/:idProposal', {
            templateUrl: '/assets/html_fragments/proposalInfo.html',
            controller: 'proposalInfo'
        }).
        when('/proposal/modify/:idProposal',{
            templateUrl: '/assets/html_fragments/proposalModify.html',
            controller: 'proposalModify'
        }).
        when('/proposal/new/:idProposal', {
            templateUrl: '/assets/html_fragments/proposalNew.html',
            controller: 'proposalNew'
        }).
        when('/proposals', {
            templateUrl: '/assets/html_fragments/proposalList.html',
            controller: 'proposalList'
        }).
        // Where to redirect if nothing above is applied
        otherwise({
            /*default page, should be /1 but it can be changed, as long as nubmer is
             * id of root activity
             * */
            redirectTo: '/activity/1'
        });
}]);
