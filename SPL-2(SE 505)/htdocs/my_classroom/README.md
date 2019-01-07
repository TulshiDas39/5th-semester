Zenoir
==========

##Overview

Zenoir Online Classroom is an E-learning system which is mainly targeted towards teachers and students to implement online learning. The importance of these kinds of software is that it encourages the participation of students in the classroom this is implemented in the sessions module of the system which emulates classroom discussions in the real world. 
The system is composed of two modules, the administrator module and the classroom module. The administrator module is mainly used for managing user accounts, courses, subjects and classrooms. The classroom module is mainly used by the teachers and students for their online interactions such as participating in online discussions, submitting assignments, downloading handouts, and sending messages to other users in the classroom.


##Tech Stack

Here's a list of some of the technologies, libraries, frameworks and plugins used in the system. You can use them to further customize and improve the system.

###Technology

- HTML5 - Page structure
- CSS3  - Styling
- PHP - Backend stuff
- JavaScript - Frontend stuff
- Node.js , Now.js, Socket.io � for real-time chat
- MySQL - Database

###Framework

- [CodeIgniter](http://codeigniter.com/) - Backend handling, MVC


###Library

- [jQuery](http://jquery.com/) - DOM Manipulation, Event-delegation and other frontend stuff


###Plugins

- [Data Tables](http://datatables.net/) � for adding sorting, searching, and paging functionality to tables
- [jQuery UI](http://jqueryui.com/) � Calendar, Buttons
- [JScrollPane](http://jscrollpane.kelvinluck.com/) � for customizing the default scrollbars
- [HTML KickStart](http://www.99lime.com/) � used for most of the UI elements
- [Noty](http://needim.github.com/noty/) � for the notifications (Eg. Error, Success)
- [Pixel Cone File Uploader](http://pixelcone.com/jquery/ajax-file-upload-script/) � for handling file uploads


##Current Features
- User information import tool - This tool is used to easily import existing user information from another database into the Zenoir database
- Adding of subjects, classes, and courses
- Creating and updating user accounts
- Creating assignments, quizzes, and handouts, sending messages
- Creating groups - groups can be created by teacher or students.
This is primarily used in group activities like group sessions where only the members of the group can participate in the sessions 
- Sessions - This is where the teachers and students can interact with each other in real-time through chat.
- User activity log - student activity is recorded by the system, this is useful in monitoring if the students are all doing their tasks in the classroom. 
Messages are not recorded as they are private. 
- Class Settings - only the teacher can access the class settings. The teacher can invite students, accept pending students, remove current students, enable or disable modules, set email notifications, and export classroom data.


##Todo

- Admin must be able to do anything - currently the admin can only enter the classroom but not actually interact with it
- Default image for users without pictures
- Links to unread posts - currently users can only view the title for the unread posts
- Alerts for expired content (Eg. assignments that have expired) which cannot be viewed - currently the page merely refreshes if the content can no longer be viewed
- Facebook Integration - when teacher posts an assignment it will be posted in their messages on facebook
- Notification Settings - users should be able to control whether they will receive notifications or not
- Additional Quiz Types - currently only essay type and multiple choice quiz can be created by teachers. Additional quiz types such as
identification, fill in the blanks, pop-up quiz, matching, ordering, true or false. Multiple choice should also be improved, currently the teacher can only add 5 choices for each quiz item

If you want to know more about this project, you can read [the documentation](https://dl.dropbox.com/u/27328449/Zenoir%20Online%20Classroom%20Users%20Manual.pdf)


##Project Status

Abandonware. I no longer have any plans on improving and maintaining this project.


##License

The MIT License (MIT) Copyright (c)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.