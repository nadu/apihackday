<cfsetting showdebugoutput="No">
<cfparam name="url.node" default="default">
<cfparam name="form.Digits" default="">
<cfcontent type="text/xml">
<!---  @start snippet--->
<!---  Define Menu  --->
<cfset web = StructNew()>
<cfset web["default"] = ["receptionist","hours", "location", "duck"]>
<cfset web["location"] =["receptionist","east-bay", "san-jose", "marin"]>
<cfset node = url.node> 
<cfset index = form.Digits>
<cfif isnumeric(index)>
	<Cfset index=index+1> <!--- CF array index starts at 1 --->
</cfif>
<cfset url = "phonemenu.php">
 
<cfif isnumeric(index) and index gte 0 and StructKeyExists(web,node)  >
    <cfset destination = web[node][index]>
<cfelse>
    <cfset destination = "">
</cfif>	

<!---  @end snippet--->
<!---  @start snippet--->
<!---  Render TwiML  --->
<CFContent type="text/xml">
<cfsetting showdebugoutput="no">
<cfinclude template="TwilioSettings.cfm" />
<cfset t = createObject("component", "TwilioLib").init(AccountSid, AuthToken) />
<cfset r = t.newResponse() />

<cfswitch expression="#destination#">
	<cfcase value="hours">
		<cfset r.Say("Initech is open Monday through Friday, 9am to 5pm") />
		<cfset r.Say("Saturday, 10am to 3pm and closed on Sundays") />
	</cfcase>
	<cfcase value="location">
		<cfset r.Say("Initech is located at 101 4th St in San Francisco California") />
		<cfset r.gather(numDigits="1", Action="phonemenu.cfm?node=location") />
		<cfset r.say(body="For directions from the East Bay, press 1", voice="man", childOf="gather") />
		<cfset r.say(body="For directions from San Jose, press 2", voice="man", childOf="gather") />
	</cfcase>
	<cfcase value="east-bay">
		<cfset r.Say("Take BART towards San Francisco / Milbrae. Get off on Powell Street. Walk a block down 4th street") />
	</cfcase>
	<cfcase value="san-jose">
		<cfset r.Say("Take Cal Train to the Milbrae BART station. Take any Bart train to Powell Street") />
	</cfcase>
	<cfcase value="duck">
		<cfset r.Play("duck.mp3") />
	</cfcase>
	<cfcase value="receptionist">
		<cfset r.Say("Please wait while we connect you") />
		<cfset r.Dial("NNN") />
	</cfcase>
	<cfdefaultcase>
		<cfset r.gather(numDigits="1", Action="phonemenu.cfm?node=default") />
		<cfset r.say(body="Hello and welcome to the Ini tech Phone Menu", voice="man", childOf="gather") />
		<cfset r.say(body="For business hours, press 1", voice="man", childOf="gather") />
		<cfset r.say(body="For directions, press 2", voice="man", childOf="gather") />
		<cfset r.say(body="To hear a duck quack, press 3", voice="man", childOf="gather") />
		<cfset r.say(body="To speak to a receptionist, press 0", voice="man", childOf="gather") />
	</cfdefaultcase>
</cfswitch>
<!---  @end snippet--->
<!---  @start snippet--->
<cfif destination is not "receptionist">
	<cfset r.pause(length="1")>
	<cfset r.Say("Main Menu") />
	<cfset r.redirect("phonemenu.cfm")>
</cfif>
<!---  @end snippet--->

<cfoutput>#r.getResponse()#</cfoutput>
