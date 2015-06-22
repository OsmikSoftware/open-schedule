This is open source project #2 from Kos to Coast Development. As with the first one, this is one for the work force. Originally built as a platform for Stanford University before they switched to a paid service, I determined that I did not want to scrap the code I wrote, as it has great potential. So here we are, open source project #2!

This is a platform that your workforce will be able to use to schedule employees based on availability, as well as enable employees to post their shifts in hopes another co-worker can swap or work their shift, if your organization allows it.

Currently, this is built using PHP, jquery, and bootstrap 2.3, but once again, I MAY rebuild it using a framework, as I rebuilt open-test with Angular. I may experiment with another framework...or even create my own? haha nah but only time will tell.

Currently to software only accomodates substitution requests. Scheduling will be added in a later push.

The db schema is configured to have 3 tables -- work locations,requests, and request-takers. They stand for the location of work, the person initiating the substitute request, and the person taking the request.

These tables will differ based on the specifics of your organization, of course. For the location table, it only has 2 columns, a location id and location name.

The requests table has 10 columns:
-id(INT)
-name(varchar50)
-email(varchar50)
-location_id(smallint)
-request_date(date needed the substitute for)(int)[unix stamp at time of writing, but will be removed in later push]
-shift_start(int)(at time of writing, but will be converted to datetime in later push))
-shift_end(int)(will be switched later also))
-details(of the request)(text)
-date_requested(int)(will be converted to datetime in later push)
-is_taken(tinyint)

The request_takers table has 5 columns:
-id(int)
-request_id(id)
-name(varchar50)
-email(varchar50)
-date(int)[will be converted to datetime in later push]

Functionality
A person will enter a date and time for their work shift to be posted for substitution for another coworker. Another coworker will view the board, and take the shift if they desire. When the shift gets picked up, an email gets sent out to both parties, along with management about the shift transaction. The requests are also color-coded on the board, indicating availability of the shift-green for available and red for taken.

This is pretty much all I have for a readme at this point. Please excuse any typos you may spot, as I'm typing this in Vi.

As always, for support, feel free to contact me at mikos@kostocoastdev.com

Thanks!
