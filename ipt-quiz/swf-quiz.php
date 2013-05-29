<?php
/*
Template Name: SWF Quiz
*/
?>

<html>
  <head>
    <TITLE>Fresh Produce Inspection Quiz</TITLE>

    <meta http-equiv="Content-Type" content="text/html;  charset=ISO-8859-1">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="imagetoolbar" content="false">
<META name="description" content="Articulate - The global leader in rapid e-learning.">
<META name="keywords" content="Articulate, Articulate Quizmaker, create quizzes, create surveys, rapid e-learning, SCORM, AICC, Flash, e-learning">
<!-- ########################################################## -->
<SCRIPT LANGUAGE='JavaScript1.2' SRC='/wp-content/themes/ipt/swf/quizmaker.js' TYPE='text/javascript'></SCRIPT>
<script LANGUAGE="JavaScript">
<!--
// Set some global values...
var g_bLMS 		= false;
var g_strEmail = "";
var g_strSubject = "";
var g_strQuizResults  = "";
// Browser Detectio Monstra
var NS4 = (navigator.appName.indexOf("Netscape")>=0 && parseFloat(navigator.appVersion) >= 4 && parseFloat(navigator.appVersion) < 5)? true : false;
var IE4 = (document.all)? true : false;
var NS6plus = (parseFloat(navigator.appVersion) >= 5 && navigator.appName.indexOf("Netscape")>=0 )? true: false;
var isMac = (navigator.appVersion.indexOf("Mac")!=-1) ? true : false;
var IEmac = ((document.all)&&(isMac)) ? true : false;
var IE4plus = (document.all) ? true : false;
var IE5 = ((document.all)&&(navigator.appVersion.indexOf("MSIE 5.")!=-1)) ? true : false;
var IE6 = ((document.all)&&(navigator.appVersion.indexOf("MSIE 6.")!=-1)) ? true : false;
var IE7 = ((document.all)&&(navigator.appVersion.indexOf("MSIE 7.")!=-1)) ? true : false;
var Opera7plus = ((document.all)&&(navigator.userAgent.indexOf("Opera 7")!=-1)) ? true : false;
var FF = (navigator.userAgent.indexOf("Firefox")!=-1) ? true : false;
var FF1 = (navigator.userAgent.indexOf("Firefox\/1")!=-1) ? true : false;
var FF2 = (navigator.userAgent.indexOf("Firefox\/2")!=-1) ? true : false;
var Opera = (navigator.userAgent.indexOf("Opera")!=-1) ? true : false;
var Mozilla = (NS6plus && (navigator.userAgent.indexOf("Netscape") < 0));
var NS7_2Plus = false;
var Mozilla1_7Plus = false;
var isLinux = (navigator.userAgent.indexOf("Linux") != -1);
var isWindows = (!isMac && !isLinux)
// Find the version of NS or Mozilla
if (NS6plus)
{
var nPos = 0;
var strUserAgent = navigator.userAgent;
var nReleaseDate = 0;

strUserAgent = strUserAgent.toLowerCase();
nPos = strUserAgent.indexOf("gecko/");
if(nPos >= 0)
{
var strTemp = strUserAgent.substr(nPos + 6);
nReleaseDate = parseFloat(strTemp);
}
if (strUserAgent.indexOf("netscape") >= 0)
{
if (nReleaseDate >= 20040804)
{
NS7_2Plus = true;
}
}
else
{
if (nReleaseDate >= 20040616)
{
Mozilla1_7Plus = true;
}
}
}
//windows sp2:
var IESP2 = false;
if ((window.navigator.userAgent.indexOf("MSIE")) && window.navigator.userAgent.indexOf("SV1") > window.navigator.userAgent.indexOf("MSIE"))
{
IESP2 = true;
}
var aw;
var ah;
var isAlreadySubmitted=false; //for the final exit message
// -->
</script>
<!-- LMS Command processing -->
<SCRIPT LANGUAGE="JavaScript1.2">
<!--
if (g_bLMS)
{
document.write("<SCR" + "IPT LANGUAGE='JavaScript1.2' SRC='lms/lms.js' TYPE='text/javascript'><\/SCR" + "IPT>");
}
function debug()
{
}
function SendQuiz()
{
g_strQuizResults = g_strQuizResults.replace(/'/g,"&#39;");
var sHTML = "";
sHTML += '<FORM id="formQuiz" method="POST" action="mailto:' + g_strEmail + '?subject=' + g_strSubject + '" enctype="text/plain">';
sHTML += '<INPUT TYPE="hidden" NAME="Quiz Results" VALUE=\'' + g_strQuizResults.replace(/\\n/g,"\n") + '\'>';
sHTML += '<br><input type="submit"><br>';
sHTML += '</FORM>';
document.getElementById("divQuiz").innerHTML = sHTML;
document.getElementById("divQuiz").document.getElementById("formQuiz").submit();
}
////////////////////////////////////////////////////////////////////////////////
// Results Screen Code
////////////////////////////////////////////////////////////////////////////////
var g_arrResults = new Array();
var g_oQuizResults = new Object();
function QuestionResult(nQuestionNum, strQuestion, strResult, strCorrectResponse, strStudentResponse, nPoints)
{
if (nPoints < 0)
{
nPoints = 0;
}
if (strCorrectResponse == "")
{
strCorrectResponse = "&nbsp;";
}
this.nQuestionNum = nQuestionNum
this.strQuestion = strQuestion;
this.strCorrectResponse = strCorrectResponse;
this.strStudentResponse = strStudentResponse;
this.strResult = strResult;
this.nPoints = nPoints;
this.bFound = false;
}
function StoreResult(args)
{
args = args.replace(/\|\$s\$\|/g,";")
var arrParams = args.split("|$:$|");
var oQuestionResult = new QuestionResult(parseInt(arrParams[0]) + 1, arrParams[1], arrParams[2], arrParams[3], arrParams[4] ,arrParams[5]);
var nIndex = g_arrResults.length;
// Lets see if we have answered the question before
for (var i = 0; i < g_arrResults.length; i++)
{
if (g_arrResults[i].nQuestionNum == oQuestionResult.nQuestionNum)
{
nIndex = i;
break;
}
}
g_arrResults[nIndex] = oQuestionResult;
}
function StoreQuizResult(args)
{
var arrParams = args.split("|$:$|");
g_oQuizResults.dtmFinished = new Date();
g_oQuizResults.strResult = arrParams[0];
g_oQuizResults.strScore = arrParams[1];
g_oQuizResults.strPassingScore = arrParams[2];
}
function ShowResult(args)
{
var arrData = args.split("|$s$|");

g_oQuizResults.oOptions = new Object();
g_oQuizResults.oOptions.bShowUserScore = (arrData[0] == "1");
g_oQuizResults.oOptions.bShowPassingScore = (arrData[1] == "1");
g_oQuizResults.oOptions.bShowShowPassFail = (arrData[2] == "1");
g_oQuizResults.oOptions.bShowQuizReview = (arrData[3] == "1");
g_oQuizResults.oOptions.strResult = arrData[4];
g_oQuizResults.oOptions.strName = arrData[5];
window.open(GetBasePath() + "report.html", "Reports")
}
////////////////////////////////////////////////////////////////////////////////
// Attachment code
////////////////////////////////////////////////////////////////////////////////
function GetBasePath()
{
var strFullPath = document.location.href;
var nPos1 = -1;
var nPos2 = -1;
nPos1 = strFullPath.lastIndexOf("\\");
nPos2 = strFullPath.lastIndexOf("/");
if (nPos2 > nPos1)
{
nPos1 = nPos2;
}
if (nPos1 >= 0)
{
strFullPath = strFullPath.substring(0, nPos1 + 1);
}
return(strFullPath);
}
var g_strAttachment = "";
function OpenAttachment()
{
if (IESP2)
{
window.open('/wp-content/themes/ipt/swf/attach.html?' + GetBasePath() + g_strAttachment,"attach")
}
else
{
window.open(GetBasePath() + g_strAttachment);
}
}
////////////////////////////////////////////////////////////////////////////////
// Zoom code
////////////////////////////////////////////////////////////////////////////////
var g_oZoomInfo = new Object();
var g_wndZoom;
function PopZoomImage(strFileName, nWidth, nHeight)
{
var strScroll = "0";
g_oZoomInfo.strFileName = strFileName;
g_oZoomInfo.nWidth = parseInt(nWidth);
g_oZoomInfo.nHeight = parseInt(nHeight);
if (g_oZoomInfo.nWidth > screen.availWidth)
{
g_oZoomInfo.nWidth = screen.availWidth;
strScroll = "1";
}
if (g_oZoomInfo.nHeight > screen.availHeight)
{
g_oZoomInfo.nHeight = screen.availHeight;
strScroll = "1";
}
var strOptions = "width=" + g_oZoomInfo.nWidth +",height=" + g_oZoomInfo.nHeight + ", status=0, toolbar=0, location=0, menubar=0, scrollbars=" + strScroll;
if (g_wndZoom)
{
try
{
g_wndZoom.close()
}
catch (e)
{
}
}
g_wndZoom = window.open(GetBasePath() + "zoom.html", "Zoom", strOptions);
}
////////////////////////////////////////////////////////////////////////////////
function CloseWindow()
{
window.close();
}
function player_DoFSCommand(command, args)
{
args = String(args);
args = args.replace(/%_q_%/g,"\"")
args = args.replace(/;/g,"|$s$|")
args = args.replace(/%_s_%/g,";")
command = String(command);
var F_intData = args.split("|$s$|");
switch (command)
{
case "ART_CloseAndExit":
if (!g_bLMS)
{
//QM customized//
if (FF)
{
setTimeout("CloseWindow()", 100);
}
else
{
window.close();
}
}
break;
//Email//
case "emailEmail":
g_strEmail = args;
break;
case "QuizResults":
case "Quiz Results":
var strTemp = args.replace(/\|\$s\$\|/g,";");
g_strQuizResults = strTemp;
break;
case "emailSubject":
g_strSubject = args;
break;
case "emailSubmit":
SendQuiz();
break;
case "StoreQuestionResult":
StoreResult(args);
break;
case "StoreQuizResult":
StoreQuizResult(args);
break;
case "DisplayPrintScreen":
ShowResult(args);
break;
case "ART_QMAttachment":
g_strAttachment = args;
if (IESP2)
{
OpenAttachment()
}
else
{
setTimeout("OpenAttachment()", 100)
}
break;
case "QM_ZoomImage":
PopZoomImage(F_intData[0], F_intData[1], F_intData[2]);
break;
}
if (g_bLMS)
{
customFScommandHandler(command, args);
}
}
//-->
</SCRIPT>
<SCRIPT LANGUAGE="VBScript">
<!--
// Catch FS Commands in IE, and pass them to the corresponding JavaScript function.
Sub player_FSCommand(ByVal command, ByVal args)
call player_DoFSCommand(command, args)
end sub
// -->
</SCRIPT>
<script LANGUAGE="JavaScript">
<!--
function thisMovie(movieName)
{
// IE and Netscape refer to the movie object differently for our ongoing pleasure.
//usage: thisMovie('player').SetVariable('_root.mcMyNotes.vMySlideNotes',  str );
if (navigator.appName.indexOf ("Microsoft") !=-1)
{
return window[movieName]
}
else
{
return document[movieName]
}
}
//-->
</script>
  </head>
  <body>
<table border=0 cellpadding=0 cellspacing=0 width="728" align=center>
<tr>
	<td align=right>

<script>
	// Create FlashVars
	var strFlashVars = "";

	// FSCommand?
	strFlashVars += "vFSCommand="
	if (!(IE5 || IE6 || IE7 || FF1 || NS7_2Plus || Mozilla1_7Plus) || Opera || isLinux || isMac || FF2)
	{
		strFlashVars += "false";	 
	}
	else
	{
		strFlashVars += "true"
	}

	WriteSwfObject("/wp-content/themes/ipt/swf/assessment.swf", 720, 540, "noscale", "middle", "best", "#cccccc", strFlashVars)

</script>


</table>
<table border=0 cellpadding=0 cellspacing=0 width="728" align=center>
<tr><td align=right class="pb">Powered by <a href="http://www.articulate.com/quizmaker" target="_blank">Articulate Quizmaker</a>&nbsp;&nbsp;&nbsp;</td></tr>
</table>
<style>
.pb { font-family: arial; font-size:9px; color:#aaaaaa; }
.pb A { color:#aaaaaa;  }
</style>


<!-- Email support -->
<DIV id="divQuiz" style="visibility:hidden">
</DIV>
  </body>
</html>
