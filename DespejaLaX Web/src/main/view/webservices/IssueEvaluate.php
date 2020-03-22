<?php

// Get the parameters
$solution = UtilsHttp::getParameterValue('solution');

// Evaluate the solution
ManagerGame::evaluateSolution($solution);