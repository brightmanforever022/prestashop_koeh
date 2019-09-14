<div class="panel">
    <div class="panel-body">
        <div class="col-lg-6">
        <h4>Use images from your Google Drive</h4>
        <p>Images will be downloaded from your Drive account and stored on the server</p>
        <pre id="content" style="white-space: pre-wrap;"></pre>
        <!--Add buttons to initiate auth sequence and sign out-->
        <button id="authorize_button" style="display: none;" class="btn btn-success">Authorize website to access your Google Drive</button>
        <button id="signout_button" style="display: none;" class="btn btn-warning">Sign Out website</button>

    
        <ul id="driveFolders" class="list-group" style="height:800px;overflow: auto;">

        </ul>
    
        </div>
        <div class="col-lg-6">
            <div id="driveProcessMessages"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('#driveFolders').on('click', 'button.gfolder-navigate', function(){
        if( $(this).hasClass('gfolder-parent') ){
        	KhlGDrive.listFolders(-1);
        }
        else{
            let gdFolder = $(this).parent().data('gfolder');
            KhlGDrive.listFolders(gdFolder);
        }
    });
    $('#driveFolders').on('click', 'button.gfolder-download', function(){
    	KhlGDrive.downloadFolder( $(this).parent().data('gfolder') );
    });
});
</script>
    <script type="text/javascript">
      // Client ID and API key from the Developer Console
      var CLIENT_ID = '{$GGL_DRV_CLIENT_ID}';
      var API_KEY = '{$GGL_DRV_API_KEY}';

      // Array of API discovery doc URLs for APIs used by the quickstart
      var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/drive/v3/rest"];

      // Authorization scopes required by the API; multiple scopes can be
      // included, separated by spaces.
      var SCOPES = 'https://www.googleapis.com/auth/drive.readonly';

      var authorizeButton = document.getElementById('authorize_button');
      var signoutButton = document.getElementById('signout_button');

      var gAuthResponse = null;
      /**
       *  On load, called to load the auth2 library and API client library.
       */
      function handleClientLoad() {
        gapi.load('client:auth2', initClient);
      }

      /**
       *  Initializes the API client library and sets up sign-in state
       *  listeners.
       */
      function initClient() {
        gapi.client.init({
          apiKey: API_KEY,
          clientId: CLIENT_ID,
          discoveryDocs: DISCOVERY_DOCS,
          scope: SCOPES
        }).then(function () {
          // Listen for sign-in state changes.
          gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

          // Handle the initial sign-in state.
          updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
          authorizeButton.onclick = handleAuthClick;
          signoutButton.onclick = handleSignoutClick;
        }, function(error) {
          appendPre(JSON.stringify(error, null, 2));
        });
      }

      /**
       *  Called when the signed in status changes, to update the UI
       *  appropriately. After a sign-in, the API is called.
       */
      function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
        	
        	gapi.auth2.getAuthInstance().currentUser.get().reloadAuthResponse().then(function(AuthResponse){
        		gAuthResponse = AuthResponse;
            });
          authorizeButton.style.display = 'none';
          signoutButton.style.display = 'block';
          //listFiles();
          KhlGDrive.init({
              'foldersContainerId':'driveFolders'
          });
          KhlGDrive.listFolders();
        } else {
          authorizeButton.style.display = 'block';
          signoutButton.style.display = 'none';
        }
      }

      /**
       *  Sign in the user upon button click.
       */
      function handleAuthClick(event) {
        gapi.auth2.getAuthInstance().signIn();
      }

      /**
       *  Sign out the user upon button click.
       */
      function handleSignoutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
      }
      function appendPre(message) {
          var pre = document.getElementById('content');
          var textContent = document.createTextNode(message + '\n');
          pre.appendChild(textContent);
      }

    </script>

    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>