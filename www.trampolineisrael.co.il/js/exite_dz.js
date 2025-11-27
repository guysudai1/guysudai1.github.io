(function ( $ ) {
    $.fn.dz = function( options ) {
    	var elClass=this.attr('class').replace(/ /gi,'.');
    	if ($("."+elClass + ' div.exite_dropzone_file').length<1) this.append('<div class="exite_dropzone_file"><label class="dz-message"><i class="fal fa-camera-alt"></i><br><u style="color:black">Browse</u> or Drop files here</label></div>');
       
        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            url: "/Admin/uploads/",
            maxFiles:100,
            acceptedFiles:'image/jpeg,image/png,image/gif, video/mp4, image/x-icon,image/vnd.microsoft.icon, image/webp',
            cb:'window.setTimeout("ReloadPage()",500);',
            tumbsWidth:120,
            tumbsHeight:120,
            showTumbs:true,
            maxFilesize:6,
            timeout: 180000
        }, options );
        
       		if ($('.'+elClass+' div.exite_dropzone_file.dz-clickable').length>0) Dropzone.forElement('.'+elClass+' div.exite_dropzone_file').destroy();

			    this.myDropzone = new Dropzone("."+elClass+" div.exite_dropzone_file",
			    { url: settings.url,
				    paramName:'exite_uploaded',
				    acceptedFiles:settings.acceptedFiles,
				    addRemoveLinks:true,
				    maxFiles:settings.maxFiles,
				    uploadMultiple:true,
				    thumbnailWidth:settings.tumbsWidth,
				    thumbnailHeight:settings.tumbsHeight,
				    createImageThumbnails:settings.showTumbs,
				    resizeWidth:2800,
				    maxFilesize:settings.maxFilesize,
				    timeout:settings.timeout
			    });
			    var settingBck=settings.cb;
				this.myDropzone.options.autoProcessQueue=false;
				this.myDropzone.on('error',function() {
			    	this.options.autoProcessQueue=false;
			    	settings.cb="";

				});
				this.myDropzone.on('queuecomplete',function() {
			    	this.options.autoProcessQueue=false;
			    	eval(settings.cb);

				});
				
				this.myDropzone.on('successmultiple',function(x,y) {
					var UploadedRespose=JSON.parse(y);
					$.each(UploadedRespose,function(e) {
						UpdateUploadedFile(UploadedRespose[e],UploadedRespose[e]);
					});
					
				});
				this.myDropzone.on('removedfile',function() {
					if ($('.'+elClass+' div.exite_dropzone_file .dz-preview').length<1) $('.'+elClass+' div.exite_dropzone_file label').removeClass('hide');
				})
				this.isHavingFiles=false;
				this.myDropzone.on('addedfile',function() {
					
					$('div.exite_dropzone_file label').addClass('hide');this.isHavingFiles=true;if (uploader_instance) uploader_instance.isHavingFiles=true});
			this.startUpload=function() {
				settings.cb=settingBck;
    			if (Dropzone.instances.length>0) this.myDropzone.processQueue();this.myDropzone.options.autoProcessQueue=true;
    			
    		}
		return this;

	    }
    	
   
 
}( jQuery ));