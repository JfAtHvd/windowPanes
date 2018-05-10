"use strict";


/*****
***     DECLARE ALL VARIABLES
***
******/
//  CONSTANT_VARIABLES
//  Can be adjusted as necessary
var MAX_WIDTH = 16;
var MAX_HEIGHT = 16;
var MAX_SATURATION = 100;
var MIN_SATURATION = 20;
var MAX_LIGHTNESSS = 80;
var MIN_LIGHTNESSS = 23;
var MIN_MOUSE_DRAG = 20;
var SELECT_ANGLE_RATIO = 2;

var lightnessRadius = (MAX_WIDTH + MAX_HEIGHT) / 8;
//  Center constraint keeps center of color wheel from being too close to any edge.
var xCenterConstraint = MAX_WIDTH * 0.75;
var yCenterConstraint = MAX_HEIGHT * 0.75;

var puzzleObj = {};
//  initialize puzzleObj
for (var i = 0; i < MAX_HEIGHT; i++){
    puzzleObj[i] = {};
    for(var j = 0; j < MAX_WIDTH; j++){
      puzzleObj[i][j] = null;
    }
}

var squareArray = [];
//  initialize squareArray
for (var i = 0; i < MAX_HEIGHT; i++){
    squareArray[i] = [];
    for(var j = 0; j < MAX_WIDTH; j++){
      squareArray[i][j] = null;
    }
}

var patternNumbers = {
    "xOffset" : null,
    "yOffset" : null,
    "hueOriginAngle" : null
};

var flipsForThisLevel = {};

var axisHoriz;
var axisVert;
var directionToFlip;

var xMouseDown;
var yMouseDown;
var xMouseUp;
var yMouseUp;

var levelNumber;

var timer;
var totalTime;
var timerId;
var puzzleResets;
var numberFlips;
var totalNumberFlips;

/***
*   References to HTML elements:
**/
var puzzleFlip = document.getElementById("puzzleFlip");
var levelLabel = document.getElementById("levelLabel");
var btnFlip = document.getElementById("btnFlip");
var btnReset = document.getElementById("btnReset");
var timerSpan = document.getElementById("timerSpan");
var gameControls = document.getElementById("gameControls");
var winReport = document.getElementById("winReport");
//  HTML form and its inputs:
var saveDataForm = document.getElementById("saveDataForm");
var level = document.getElementById("level");
var level_json = document.getElementById("level_json");
var pattern_json = document.getElementById("pattern_json");
var solve_time = document.getElementById("solve_time");
var total_solve_time = document.getElementById("total_solve_time");
var puzzle_resets = document.getElementById("puzzle_resets");
var number_flips = document.getElementById("number_flips");
var total_number_flips = document.getElementById("total_number_flips");
//  This HTML div will exist if user is logged in, but will be undefined if not
var userLoginTrue = document.getElementById("userLoginTrue");
//  This HTML div will exist if user is redirected from home page, 
//  but will be undefined if user is redirected from within game
var newGameTrue = document.getElementById("newGameTrue");
//  END OF VARIABLE DECLARATIONS

/***
*   ADD EVENT LISTENERS TO HTML ELEMENTS
*   Sources:  https://developer.mozilla.org/en-US/docs/Web/Events/mousedown  https://developer.mozilla.org/en-US/docs/Web/API/MouseEvent/screenX
**/
puzzleFlip.addEventListener("mousedown", function (evt) {
//document.addEventListener("mousedown", function (evt) {
    evt.preventDefault();
    xMouseDown = evt.screenX;
    yMouseDown = evt.screenY;
    console.log("mousedown at screen coordinates (" + xMouseDown + "," + yMouseDown + ")");
});

puzzleFlip.addEventListener("mouseup", function (evt) {
//document.addEventListener("mouseup", function (evt) {
    xMouseUp = evt.screenX;
    yMouseUp = evt.screenY;
    if(testSelection()){
        btnFlip.addEventListener("click", executeFlip);
        //console.log("Add event listener to flip button. directionToFlip="+directionToFlip);
        addHighlights();
    } else {
        btnFlip.removeEventListener("click", executeFlip);
        //console.log("Remove event listener from flip button.");
    }
});

btnReset.addEventListener("click", resetPuzzle);
//  END OF ADD EVENT LISTENERS


/*****
***     CREATE PUZZLE FUNCTIONS
***
******/
/***
*   Fill values in patternNumbers object with new random numbers
**/
function setRandomPattern() {
    //  Offset defines where center of color wheel lies
    //  (x,y) offset of (0,0) corresponds to center of grid.
    patternNumbers.xOffset = (xCenterConstraint / 2) - Math.floor(xCenterConstraint * Math.random());
    patternNumbers.yOffset = (yCenterConstraint / 2) - Math.floor(yCenterConstraint * Math.random());
  
    //  Center constraint prevents center of color wheel aligning too closely with center of grid
    if (Math.abs(patternNumbers.xOffset) < MAX_WIDTH / 10){
        while(Math.abs(patternNumbers.yOffset) < MAX_HEIGHT / 10){
            patternNumbers.yOffset = (yCenterConstraint / 2) 
                    - Math.floor(yCenterConstraint * Math.random());
        }
    }
    patternNumbers.hueOriginAngle = 360 * Math.random();
}

/***
*   Fill values in flipsForThisLevel object with new axes and directions
*   Level number corresponds to number of axis & direction pairs
**/
function setRandomFlips(levelNumber) {
    flipsForThisLevel = {};
    console.log("Setting flips for level " + levelNumber);
    var direction;
    var axis;
    for(var i = 0; i < levelNumber; i++){
        if(Math.random() < 0.5){
            direction = "horiz";
        } else {
            direction = "vert";
        }
        if(direction === "horiz"){
            axis = Math.floor(Math.random() * (MAX_HEIGHT - 1)) + 1;
        } else {
            axis = Math.floor(Math.random() * (MAX_WIDTH - 1)) + 1;
        }
        flipsForThisLevel[i] = {
            "direction" : direction,
            "axis" : axis
        };
        for(var j = 0; j < i; j++){
            if(flipsForThisLevel[i].direction == flipsForThisLevel[j].direction &&
                    flipsForThisLevel[i].axis == flipsForThisLevel[j].axis){
				
				console.log("Repeat flip: " + flipsForThisLevel[i].direction + " " + flipsForThisLevel[j].direction +
                    " , " + flipsForThisLevel[i].axis + " " + flipsForThisLevel[j].axis);
                console.log("i= " + i + ", j= " + j);
                i--;
				break;
            }
        }
    }
    console.log(flipsForThisLevel);
}

/***
*   Mix up puzzleObj based on the flipsForThisLevel
**/
function mixUpPuzzle() {
    for(var i = 0; i < levelNumber; i++){
		var flip = flipsForThisLevel[i];
		console.log(flip);
		if(flip.direction === "horiz"){
			flipHorizAtAxis(flip.axis);
			console.log("Mix direction: " + flip.direction + ", axis: " + flip.axis);
		} else if(flip.direction === "vert"){
			flipVertAtAxis(flip.axis);
			console.log("Mix direction: " + flip.direction + ", axis: " + flip.axis);
		} else {
			console.log("Error, direction = " + flip.direction);
		}        
    }
}

/***
*   Fill puzzleObj with Square objects
*   Traits of Square objects are defined by patternNumbers object
**/
function makePuzzleObject() {   
    for(var i = 0; i < MAX_HEIGHT; i++){
        for(var j = 0; j < MAX_WIDTH; j++){
            var newSquareObj = {};
            //  Turn (i,j) coordinates into Cartesian (x,y) coordinates
            var xNewSquare = j - (MAX_WIDTH / 2) + patternNumbers.xOffset;
            var yNewSquare = (MAX_HEIGHT / 2) - i + patternNumbers.yOffset;
            //  Calculate length of radius between square and center of pattern
            var hypotenuse = Math.sqrt(xNewSquare * xNewSquare + yNewSquare * yNewSquare);
            //  Calculate angle square forms with center of puzzle
            var sinNewSquare = (yNewSquare / hypotenuse) || 0;
            var arcsinNewSquare = Math.asin(sinNewSquare);
            var angleRad = arcsinNewSquare;
            if (xNewSquare < 0) {
                angleRad = Math.PI - angleRad;
            }
            if (angleRad < 0) {
                angleRad = 2*Math.PI + angleRad;
            }
            var angleDeg = (angleRad * 360) / (2 * Math.PI);
            //  Set Hue value to angle, adjusted for origin angle of this level
            var newHue = angleDeg + patternNumbers.hueOriginAngle;
            if (newHue > 360){
                newHue = newHue - 360;
            }
            var maxDiagonal = Math.sqrt(MAX_HEIGHT * MAX_HEIGHT + MAX_WIDTH * MAX_WIDTH);
            var saturationRatio = hypotenuse / maxDiagonal;
            var newSaturation = 
                    MAX_SATURATION - saturationRatio * (MAX_SATURATION - MIN_SATURATION);
            //  Calculate adjusted radius, which goes up and down as actual radius increases
            //  This makes "bullseye" effect of light and dark rings           
            var adjustedHypotenuse = hypotenuse % (2 * lightnessRadius);
            var lightnessRatio = 
                    (Math.abs(lightnessRadius - adjustedHypotenuse)) / lightnessRadius;
            //  Set Lightness value based on CONSTANT_VARIABLES
            var newLightness = 
                    MIN_LIGHTNESSS + lightnessRatio * (MAX_LIGHTNESSS - MIN_LIGHTNESSS);
            //  Set traits of Square object          
            newSquareObj.hslColor = 
                    "hsl(" + newHue + ", " + newSaturation + "%, " + newLightness + "%)";
            newSquareObj.winningI = i;
            newSquareObj.winningJ = j;
            puzzleObj[i][j] = newSquareObj;
        }
    }
}

/***
*   Draw a new grid of HTML colored squares in the browser
*   Add a "mousedown" listener to each square that records its axis when it is clicked
*   After drawing puzzle calls checkForWin to see if current puzzle arrangement is correct
**/
function drawPuzzle(){
    puzzleFlip.innerHTML = null;    
    for(var i = 0; i < MAX_HEIGHT; i++){
        var newRow = document.createElement("DIV");
        newRow.classList.add("rowStyle");
        for(var j = 0; j < MAX_WIDTH; j++){
            var newSquare = document.createElement("DIV");
            squareArray[i][j] = newSquare;
            newSquare.setAttribute("class", "squareStyle");
            newSquare.setAttribute("id", i+","+j);
            newSquare.style.backgroundColor = puzzleObj[i][j].hslColor;
            newRow.appendChild(newSquare);
            (function(){
				var axisHorizSelected = i;
				var axisVertSelected = j;
				newSquare.addEventListener("mousedown", function(){
					console.log("axisHorizSelected="+axisHorizSelected+",axisVertSelected="+axisVertSelected);
					axisHoriz = axisHorizSelected;
					axisVert = axisVertSelected;
				});
            })();
        }         
        puzzleFlip.appendChild(newRow);
    }
    if(checkForWin()){
        finishLevel();        
    } else {
        document.removeEventListener("click", goToNextLevel);
    }
}
//  END OF CREATE PUZZLE FUNCTIONS


/*****
***     FLIP PUZZLE FUNCTIONS
***
******/
/***
*   Calls appropriate function based on vertical or horizontal direction
*   and removes event listener from flip button so no other moves can be made
*   until there is a new selection
**/
function executeFlip(){
    numberFlips++;
    if (directionToFlip === "horiz"){
        flipHorizAtAxis(axisHoriz);        
    } else if (directionToFlip === "vert"){
        flipVertAtAxis(axisVert);
    } else {
        console.log("Error! directionToFlip = "+directionToFlip);
    }
    btnFlip.removeEventListener("click", executeFlip);
}

/***
*   Vertically flips squares in the puzzleObj that are beyond the selected axisNumber
**/
function flipVertAtAxis(axisNumber) {
    if (axisNumber > 0) {
		console.log("Flip Vertical at axis "+axisNumber);
		var maxI = MAX_HEIGHT -1;
		var saveSquare;
		for (var i = 0; i < MAX_HEIGHT / 2; i++){
			for (var j = axisNumber; j < MAX_WIDTH; j++){
				saveSquare = puzzleObj[i][j];
				puzzleObj[i][j] = puzzleObj[maxI - i][j];
				puzzleObj[maxI - i][j] = saveSquare;
			}
		}
		drawPuzzle();
		clearSelection();
    } else {
        clearSelection();
        //displayFlip.innerHTML = "Anchor Square (top left) cannot be flipped";
    }
}

/***
*   Horizontally flips squares in the puzzleObj that are beyond the selected axisNumber
**/
function flipHorizAtAxis(axisNumber) {
    if (axisNumber > 0) {
		console.log("Flip Horizontal at axis "+axisNumber);
		var maxJ = MAX_WIDTH -1;
		var saveSquare;
		for (var i = axisNumber; i < MAX_HEIGHT; i++){
			for (var j = 0; j < MAX_WIDTH / 2; j++){
				saveSquare = puzzleObj[i][j];
				puzzleObj[i][j] = puzzleObj[i][maxJ - j];
				puzzleObj[i][maxJ - j] = saveSquare;
			}
		}
		drawPuzzle();
		clearSelection();
    } else {
        clearSelection();
        //displayFlip.innerHTML = "Anchor Square (top left) cannot be flipped";
    }
}
//  END OF FLIP PUZZLE FUNCTIONS


/*****
***     START LEVEL AND FINISH LEVEL FUNCTIONS
***
******/
/***
*   Load game screen.  
*   If user is not logged in, always starts from level one. Same page increments levels
*   If user logged in and starting new game, start from level one and clear localStorage
*   If user logged in and not starting new game, pull level number from localStorage
**/
function loadGame(){
    if(userLoginTrue){
        if(newGameTrue){
            localStorage.clear();
            levelNumber = 1;
        } else {
            levelNumber = parseInt(localStorage.getItem('levelNumber'), 10);
        }
    } else {
		levelNumber = 1;
    }
    startNewLevel(levelNumber);
}

/***
*   Recreates current level as it was initially presented, keeping same values in 
*   patternNumbers and flipsForThisLevel,   Adds 1 to the "puzzleResets" statistic,
*   Sets numberFlips to 0 but retains it in totalNumberFlips
**/
function resetPuzzle(){
    makePuzzleObject();
    mixUpPuzzle()
    drawPuzzle();
    resetTimer();
    puzzleResets++;
    totalNumberFlips += numberFlips;
    numberFlips = 0;
}

/***
*   Start a new level with the number of flips corresponding to the levelNumber
**/
function startNewLevel(levelNumber) {
	setRandomPattern();
	setRandomFlips(levelNumber);
	makePuzzleObject();
	mixUpPuzzle();
	drawPuzzle();
	levelLabel.innerHTML = "Level " + levelNumber;
    startNewTimer();
    puzzleResets = 0;
    numberFlips = 0;
    totalNumberFlips = 0;
    gameControls.style.visibility = "visible";
    winReport.style.visibility = "hidden";
}

/***
*   Increase the level number and start a new level 
*   For Guest users
**/
function goToNextLevel(){
    levelNumber += 1;
    startNewLevel(levelNumber);
}

/***
*   Set value for each form input to corresponding variable from level, and submit form
*   Passes number for next level into localStorage
**/
function executePuzzleForm(){
    level.value = levelNumber;
    level_json.value = JSON.stringify(flipsForThisLevel);
    pattern_json.value = JSON.stringify(patternNumbers);
    solve_time.value = timer;
    total_solve_time.value = totalTime;
    puzzle_resets.value = puzzleResets;
    number_flips.value = numberFlips;
    total_number_flips.value = totalNumberFlips;
    
    levelNumber += 1;
    localStorage.setItem('levelNumber', levelNumber);
    saveDataForm.submit();
}

/***
*   Loop through each square object in puzzleObj, if any of their current coordinates
*   do not match the winning coordinates, then return FALSE
*   If all squares pass this test at end of loop, then return TRUE
**/
function checkForWin() {
    for (var i = 0; i < MAX_HEIGHT; i++){
        for (var j = 0; j < MAX_HEIGHT; j++){
            if(puzzleObj[i][j].winningI != i || puzzleObj[i][j].winningJ != j){
                return false;
            }
        }
    }        
    return true;
}

/***
*   Called when checkForWin is true, display times/scores, 
*   determine if user is logged in and proceed to next level accordingly
**/
function finishLevel(){
    clearInterval(timerId);
    totalTime += timer;
    totalNumberFlips += numberFlips;
    gameControls.style.visibility = "hidden";
	winReport.style.visibility = "visible";
	winReport.textContent = "You completed Level " + levelNumber + " in " + 
	        formatTime(totalTime) +" using " + puzzleResets + " resets!" +
	        "\nClick anywhere to proceed to next level...";
	if(userLoginTrue){
		setTimeout(function(){
			document.addEventListener("click", executePuzzleForm);
		}, 500);
	} else {		
		setTimeout(function(){
			document.addEventListener("click", goToNextLevel);
		}, 500);        
	}
}
//  END OF START LEVEL AND FINISH LEVEL FUNCTIONS


/*****
***     SELECTION AND HIGHLIGHTING FUNCTIONS
***
******/
/***
*   Test vector of click and drag to see if it is valid selection
*   Returns TRUE and sets directionToFlip if it is valid selection
*   Returns FALSE and clears any current selection if it is not valid
*   Note: uses Screen coordinates
*   Right corresponds to X increasing, and Down corresponds to Y increasing
**/
function testSelection() {	
	removeHighlights();
	var deltaX = xMouseUp - xMouseDown;
	var deltaY = yMouseUp - yMouseDown;
	//console.log("deltaX="+deltaX+" ,deltaY="+deltaY);
	if(deltaX >= MIN_MOUSE_DRAG && Math.abs(deltaX/deltaY) > SELECT_ANGLE_RATIO){
	    if(axisVert > 0){
			console.log("Selected from vertical axis "+axisVert);
			directionToFlip = "vert";
			return true;
		}
	} else if(deltaY >= MIN_MOUSE_DRAG && Math.abs(deltaY/deltaX) > SELECT_ANGLE_RATIO){
	    if(axisHoriz > 0){
			console.log("Selected from horizontal axis "+axisHoriz);
			directionToFlip = "horiz";
			return true;
		}
	}
	clearSelection();
	return false;
}

/***
*   Reset selection variables, remove event listener that allows flips, and remove 
*   highlights from selected squares in grid
**/
function clearSelection() {
    directionToFlip = null;
    axisHoriz = null;
    axisVert = null;
    btnFlip.removeEventListener("click", executeFlip);
    console.log("Remove event listener from flip button.");
    removeHighlights();
}

/***
*   Go through Array of squares, startin from axis of selection and add .highlight class
**/
function addHighlights() {
    if (directionToFlip == "vert") {
        for (var i = 0; i < MAX_HEIGHT; i++) {
            for (var j = axisVert; j < MAX_WIDTH; j++) {
                //console.log("i="+i+",j="+j+",squareArray[i][j]="+squareArray[i][j]);
                squareArray[i][j].classList.add("highlight");             
            }
        }
    } else if (directionToFlip == "horiz") {
        for (var i = axisHoriz; i < MAX_HEIGHT; i++) {
            for (var j = 0; j < MAX_WIDTH; j++) {
                squareArray[i][j].classList.add("highlight");              
            }
        }
    } else {
        console.log("Error, directionToFlip = " + directionToFlip);
    }
}

/***
*   Go through Array of all squares and remove .highlight class
**/
function removeHighlights() {
   for (var i = 0; i < MAX_HEIGHT; i++) {
		for (var j = 0; j < MAX_WIDTH; j++) {
			squareArray[i][j].classList.remove("highlight");
		}
	}
}
//  END OF SELECTION AND HIGHLIGHTING FUNCTIONS


/*****
***     TIMER FUNCTIONS
***
******/
/***
*   Start a brand new timer with current time and total time both starting from 0
**/
function startNewTimer(){
    clearTimer()
    timer = 0;
    totalTime = 0;
	timerId = setInterval(function(){
		timerSpan.textContent = "Time " + formatTime(timer);
		timer++;
	},1000);
}

/***
*   Stop current timer, add current time to total time, and start a new current timer
**/
function resetTimer(){
    totalTime += timer;
    timer = 0;
    clearTimer();
    timerId = setInterval(function(){
		timerSpan.textContent = "Time " + formatTime(timer);
		timer++;
	},1000);
}

/***
*   Stop timer from counting up, and clear text from clock HTML span
**/
function clearTimer(){
    clearInterval(timerId);
    timerSpan.textContent = null;
}

/***
*   Return a time in seconds to a formatted string in minutes and seconds.
**/  
function formatTime(t){
	var minutes = Math.floor(t / 60);
	var seconds = (t % 60).toString();
	if(seconds.length == 1){
		seconds = "0" + seconds;
	}
	return minutes + ":" + seconds;
}
//  END OF TIMER FUNCTIONS



loadGame();

	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		