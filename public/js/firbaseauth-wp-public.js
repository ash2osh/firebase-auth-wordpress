/* global firebase, firebaseui, FAWP_PHPVAR */

(function ($) {
    'use strict';

    $(function () {
        var site_url = FAWP_PHPVAR.siteurl; //outputs the site url without last /
        var islogged = FAWP_PHPVAR.islogged; //is user logged to wp (not checking for firebase login)
        var fireconfig = FAWP_PHPVAR.fireconfig;
        var authurl = FAWP_PHPVAR.authurl;
        var authproviders = FAWP_PHPVAR.authproviders;
//console.log(FAWP_PHPVAR);

// Initialize Firebase
        var config = fireconfig;
        try {
            firebase.initializeApp(config);
        } catch (e) {
            console.log(e);
        }


//initialize  firebase ui app
        var initApp = function () {
            firebase.auth().onAuthStateChanged(function (user) {
                
                if (user) {
                    //if user logged out word press he shuld be logged out firebase as well
                    if (!islogged) {
                        firebase.auth().signOut();
                    }
//                        user.getIdToken().then(function (accessToken) {            });

                } else {
                    if ($("#firebaseui-auth-container").length > 0) {
                        // The start method will wait until the DOM is loaded.
                        ui.start('#firebaseui-auth-container', uiConfig);
                    }
                }
            }, function (error) {
                console.log(error);
            });
        };
        // FirebaseUI config.
        var uiConfig = {
            callbacks: {
                signInSuccess: function (currentUser, credential, redirectUrl) {

//            console.log(currentUser);
//            console.log(credential);
//            console.log(redirectUrl);
                    var acct = null;
                    currentUser.getIdToken().then(function (accessToken) {
                        acct = accessToken;
                        window.location.replace(site_url + "/" + authurl + "?tokken=" + acct);
                    });
                    // Return type determines whether we continue the redirect automatically
                    // or whether we leave that to developer to handle.

                    return false;
                },
            },
            signInFlow: 'popup', //redirect or popup
            signInSuccessUrl: site_url,
            signInOptions: authproviders,
            // Terms of service url.
            tosUrl: '<your-tos-url>'
        };

        try {
            // Initialize the FirebaseUI Widget using Firebase.
            var ui = new firebaseui.auth.AuthUI(firebase.auth());
            initApp(); //initilize the firebase app 
        } catch (e) {
            console.log(e);
        }



    }); //end (function ($) {

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
})(jQuery);
