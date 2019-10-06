var auth,signedIn=false,loaded=false,stack=[];

function checkScripts(s=1){
	var scripts=["ajaxScript","googleAPIScript"];
	var scriptSrcs=["https://code.jquery.com/jquery-3.2.1.min.js","https://apis.google.com/js/api.js?onload=counter"];
	for(i=0;i<scripts.length;i++){
		if(!document.getElementById(scripts[i]) && (scripts[i]==s || s==1)){
			var script=document.createElement("script");
			script.setAttribute("src",scriptSrcs[i]);
			script.id=scripts[i];
			document.body.appendChild(script);
		}
	}
}

function counter(){loaded=true;}

function createSignin(eid=false){
	r=()=>{
		if(document.getElementById(eid) || !eid){
			eid=$("#"+((eid)?eid:"none"));
			
			var ms=$("meta"),c=0,found=false;
			meta=null;
			ms.map(function(){
				if(ms.eq(c).attr("name")=="google-signin-client_id")found=true;
				c++;
			});

			if(!found){
				var meta=document.createElement("meta");
				meta.setAttribute("name","google-signin-client_id");
				meta.setAttribute("content","435629484672-apu166vqv9g6sfd8gk0l8sp3mbiksdni.apps.googleusercontent.com");
				$("head").append(meta);
			}

			var cbtn=document.createElement("button");
			cbtn.id="clickBTN";
			cbtn.innerHTML=(signedIn)?"Sign out":"Sign in";
			eid.append(cbtn);

			gapi.load("auth2",function(){
				auth2=gapi.auth2.init({
					client_id: '435629484672-apu166vqv9g6sfd8gk0l8sp3mbiksdni.apps.googleusercontent.com',
					cookiepolicy: 'single_host_origin',
					scope: 'profile'
				});

				auth2.attachClickHandler(document.getElementById("clickBTN"),{},function(googleUser){
					console.log(googleUser);
				},function(error){
					alert(JSON.stringify(error,undefined,2));
				});
			});
		}
		else console.error("Element not found!");
	};
	checkScripts();
	if(!loaded){stack.push(function(){createSignin(eid)});}
	else{r();}

	return "complete!";
}

function iterateStack(){
	stack.map(function(e){e();stack.splice(0,1);});
	setTimeout(iterateStack,100);
}
iterateStack();