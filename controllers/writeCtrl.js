angular.module('nouvel').controller('writeCtrl', ['$scope', function($scope) {
	// Data binded content of the editor
	$scope.editorText = '';

	// Status of the bold text button
	$scope.boldSet = false;

	// Function to toggle bold text
	$scope.setBold = function() {
		console.log($scope.editorText);
		// If not currently set, set to bold
		if(!$scope.boldSet) {
			$scope.editorText += '<b>';
		}
		else {
			$scope.editorText += '</b>';
		}
	}
}]);