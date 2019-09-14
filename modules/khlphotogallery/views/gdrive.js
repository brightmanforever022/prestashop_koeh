/**
 * 
 */
var KhlGDrive = {
	foldersContainer: null,
	foldersPath: [],
	init: function(config){
		this.foldersContainer = $('#'+config.foldersContainerId);
	},
	downloadFolder: function(gdFolder){
		$('#driveProcessMessages').html('Downloading files...');
		let params = {
			'gfolder_id' : gdFolder.id,
			'gfolder_name': gdFolder.name,
			'access_token' : gAuthResponse.access_token
		};
		$.ajax({
			url: currentIndex + '&token='+ token + '&ajax=1&action=gdrive_download_folder',
			method: 'POST',
			data: params,
			success: function(response){
				$('#driveProcessMessages').html(response);
			},
			error: function(error){
				alert(error);
			}
		});
	},
	getFoldersList: function(gdFolder, isRoot = false){
		//console.log(gdFolder.id);return;
		$('#driveFolders').empty().append('<li class="list-group-item">Loading...</li>');
		gapi.client.drive.files.list({
			q: '"'+ gdFolder.id +'" in parents'
		})
		.then(function(response){
			let parentFolder = null;
			if( KhlGDrive.foldersPath.length > 1 ){
				parentFolder = KhlGDrive.foldersPath[ KhlGDrive.foldersPath.length-2 ];
			}
			
			$('#driveFolders').empty();
			
			if( parentFolder !== null ){
				let navigateButton = $('<button><strong>Return to '+ parentFolder.name +'</strong></button>')
					.attr({
						'type' : 'button',
						'class' : 'btn btn-link gfolder-navigate gfolder-parent'
					})
				;

				let li = $('<li></li>')
					.attr({
						'class' : 'list-group-item gfolder-navigate gfolder-parent',
					})
					.data('gfolder', parentFolder)
					.append(navigateButton)
				;
				$('#driveFolders').append(li);
			}

			if( !response.result.files.length ){
				let li = $('<li>Folder is empty</li>')
				.attr({
					'class' : 'list-group-item',
				})
				.data('gfolder', response.result.files[i]);
				$('#driveFolders').append(li);

			}
			else{
				for(let i in response.result.files){
					if( response.result.files[i].mimeType == 'application/vnd.google-apps.folder' ){
						let navigateButton = $('<button>'+ response.result.files[i].name +'</button>')
							.attr({
								'type' : 'button',
								'class' : 'btn btn-link gfolder-navigate'
							})
						;
						let dwnldButton = $('<button>Download this folder</button>')
							.attr({
								'type' : 'button',
								'class' : 'btn btn-primary btn-xs pull-right gfolder-download'
							})
						;

						let li = $('<li></li>')
							.attr({
								'class' : 'list-group-item',
							})
							.data('gfolder', response.result.files[i])
							.append(navigateButton)
							.append(dwnldButton)
						;
						$('#driveFolders').append(li);
					}
				}
				for( let i in response.result.files ){
					if( response.result.files[i].mimeType != 'application/vnd.google-apps.folder' ){
						let li = $('<li>'+ response.result.files[i].name +'</li>')
							.attr({
								'class' : 'list-group-item',
							})
							.data('gfile', response.result.files[i])
						;
						$('#driveFolders').append(li);

					}
				}
			}
		});
	},
	listFolders: function(gdFolder = null){
		if( (gdFolder == -1) && KhlGDrive.foldersPath.length ){
			KhlGDrive.foldersPath.pop();
			KhlGDrive.getFoldersList( KhlGDrive.foldersPath[ KhlGDrive.foldersPath.length-1 ] );
		}
		else if( gdFolder === null ){
			gapi.client.drive.files.get({fileId:'root'})
			.then(function(response){
				KhlGDrive.foldersPath.push( response.result );
				KhlGDrive.getFoldersList(response.result, true);
			});
		}
		else if( typeof gdFolder === 'object' ){
			KhlGDrive.foldersPath.push( gdFolder );
			KhlGDrive.getFoldersList(gdFolder);
		}
	}
};