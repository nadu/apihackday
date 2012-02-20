package com.twilio;

import java.util.HashMap;
import java.util.Map;

import com.twilio.sdk.verbs.*;

public class PhoneMenu {
	
	static String BASEURL="http://www.enter_your_domain_here.com:8080/phonemenu/phonemenu.jsp";
	
	public static void main(String[] args) {
		System.out.println(PhoneMenu.getTwiML(null,null));
	}

	public static String getTwiML(String node, String digits){
		// Parse digits; represent lack of digits as -1
        int index;
        try
        	{index = Integer.parseInt(digits);}
        catch (NumberFormatException nfe)
        	{ index=-1;}

		// @start snippet
		/* Define Menu */
		String[] defaultMenu = {"receptionist","hours", "location", "duck"};
		String[] locationMenu = {"receptionist","east-bay", "san-jose"};

        Map<String,String[]> menuDefinition = new HashMap<String,String[]>();
        menuDefinition.put("default", defaultMenu);
        menuDefinition.put("location", locationMenu);

        String destination;
		/* Check to make sure index is valid */
		if(index>=0 && node!=null && menuDefinition.get(node).length >= index)
			destination = menuDefinition.get(node)[index];
		else
			destination = null;
		// @end snippet

		TwiMLResponse response = new TwiMLResponse();

        try {
	
			// @start snippet
			if (destination=="receptionist"){
		        Say say = new Say("Please wait while we connect you");
		        Dial dial = new Dial("8583829141");
		        response.append(say);
		        response.append(dial);
			} else if (destination=="hours"){
				Say say = new Say("Initech is open Monday through Friday, 9am to 5pm, Saturday, 10am to 3pm and closed on Sundays.");
				response.append(say);
			} else if (destination=="location"){
				Say say = new Say("Initech is located at 101 4th St in San Francisco California");
				response.append(say);
			} else if (destination=="duck"){
				Play play = new Play("duck.mp3");
				response.append(play);
			} else if (destination=="receptionist"){
				Say say = new Say("Initech is open Monday through Friday, 9am to 5pm, Saturday, 10am to 3pm and closed on Sundays.");
				response.append(say);
			} else if (destination=="east-bay"){
				Say say = new Say("Take BART towards San Francisco / Milbrae. Get off on Powell Street. Walk a block down 4th street.");
				response.append(say);
			} else if (destination=="san-jose"){
				Say say = new Say("Take Cal Train to the Milbrae BART station. Take any Bart train to Powell Street.");
				response.append(say);
			} else { 
				// no destination
				Gather gather = new Gather();
				gather.setAction(BASEURL + "?node=default");
				gather.setNumDigits(1);
				Say say = new Say("Hello and welcome to the Initech Phone Menu. For business hours, press 1.  For directions, press 2.  To hear a duck quack, press 3 To speak to a receptionist, press 0");
				gather.append(say);
				response.append(gather);
			}            
			
	    	if (destination=="location"){
	    		Gather gather = new Gather();
	    		gather.setAction(BASEURL + "?node=location");
	    		gather.setNumDigits(1);
	    		response.append(gather);
	    		gather.append (new Say ("For directions from the East Bay, press 1. For directions from San Jose, press 2."));
	    	}
	    	
			// @end snippet
			// @start snippet
	    	if (destination!=null && destination!="receptionist") {
				Pause pause = new Pause();
				pause.setLength(2);
				response.append(pause);
				Say menuSay = new Say("Main Menu");
				response.append(menuSay);
				Redirect redirect = new Redirect(BASEURL);
				response.append(redirect);
			}
			// @end snippet

        } catch (TwiMLException e) {
            e.printStackTrace();
        }

        return(response.toXML());
      }
}
