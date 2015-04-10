/**
 * @author Adam Borowski
 * Does programatically panning left or right to ensure that given time is visible on chart when zoomed
 * @param time in milliseconds
 */
Dygraph.prototype.panToTime = function (time) {
  var g = this;
  var range = g.xAxisRange();
  var minDate = range[0];
  var maxDate = range[1];
  var delta = 0;
  if (minDate > time) {
    delta = time - minDate;
  }
  else if (maxDate < time) {
    delta = time - maxDate;
  }
  if (delta != 0) {
    minDate += delta;
    maxDate += delta;
    g.updateOptions({
      dateWindow: [minDate, maxDate]
    });
  }
};