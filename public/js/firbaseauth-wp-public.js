(function( $ ) {
	'use strict';
var url = WPURLS.siteurl; //outputs the site url without last /

   // FirebaseUI config.
            var uiConfig = {
                callbacks: {
          signInSuccess: function(currentUser, credential, redirectUrl) {
            
//            console.log(currentUser);
//            console.log(credential);
//            console.log(redirectUrl);
            var acct =null;
            currentUser.getIdToken().then(function (accessToken) {
                acct = accessToken;
                window.location.replace(url+"/fireauth-signin?tokken="+acct);
            });
            
            // Return type determines whether we continue the redirect automatically
            // or whether we leave that to developer to handle.
            
            return false;
          },
      },
                signInFlow: 'popup', //redirect or popup
                signInSuccessUrl: url,
                signInOptions: [
                    // Leave the lines as is for the providers you want to offer your users.
                     firebase.auth.EmailAuthProvider.PROVIDER_ID,
                    // firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                    firebase.auth.FacebookAuthProvider.PROVIDER_ID,
                    firebase.auth.TwitterAuthProvider.PROVIDER_ID,
                    // firebase.auth.GithubAuthProvider.PROVIDER_ID,
                    firebase.auth.EmailAuthProvider.PROVIDER_ID,
                            // firebase.auth.PhoneAuthProvider.PROVIDER_ID
                ],
                // Terms of service url.
                tosUrl: '<your-tos-url>'
            };

            // Initialize the FirebaseUI Widget using Firebase.
            var ui = new firebaseui.auth.AuthUI(firebase.auth());




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

})( jQuery );
