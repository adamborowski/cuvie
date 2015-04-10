var PreviewController = function () {
  var constructor = function (options) {
    var data = options.data;
    var chartData = data.map(function (x) {
      return [new Date(x.date), x.value]
    });


    this.initSplitter();

    var chartElement = $('#currency-chart');
    var tableElement = $('.a-chart-table');
    var tableContainerElement = $('.a-chart-table-container');


    var lastHighlighted;
    var g = this.g = new Dygraph(chartElement.get(0), chartData, {
      labels: options.labels,
      axes: {
        y: {
          axisLabelWidth: 20
        }
      },
      valueFormatter: function (a, b, c, d, e, f) {
        if (f == 0)
          return new Date(a).format('YYYY-MM-DD');
        return a;
      },
      interactionModel: Dygraph.Interaction.defaultModel,
      labelsDivWidth: 180,
      highlightCircleSize: 4,
      rightGap: 0,
      leftGap: 0,
      showRangeSelector: true,
      rangeSelectorHeight: 30,
      fillGraph: true,
      fillAlpha: 0.8,
      color: '#079ddc',
      highlightCallback: function (a, b, c, index) {
        if (lastHighlighted)lastHighlighted.removeClass('a-highlighted-row');
        lastHighlighted = tableElement.find('tr').eq(data.length - index);
        lastHighlighted.addClass('a-highlighted-row');
        tableContainerElement.ensureVisible(lastHighlighted);
      },
      unhighlightCallback: function () {
        if (lastHighlighted)lastHighlighted.removeClass('a-highlighted-row');
        lastHighlighted = null;
      },
      drawHighlightPointCallback: function (g, series, ctx, cx, cy, color, radius) {
        ctx.lineWidth = 1;
        ctx.fillStyle = "#2184d1";
        ctx.strokeStyle = "#ffffff";
        ctx.beginPath();
        ctx.arc(cx, cy, radius, 0, 2 * Math.PI, false);
        ctx.fill();
        ctx.stroke();
      }

    });

    tableElement.on("mouseenter", "tr", function (e) {
      var index = data.length - $(this).index() - 1;
      var indexTime = chartData[index][0].getTime();
      g.panToTime(indexTime);
      g.setSelection(index);
    });

    tableElement.find('tbody').on("mouseleave", function () {
      g.clearSelection();
    });

    this.fillTable(data);
  };

  constructor.prototype.initSplitter = function () {
    var me = this;
    $('.splitter-enabled').split({
      orientation: 'horizontal',
      limit: 140,
      position: '50%',
      onDrag: function () {
        me.g.resize();
      }
    });
  };

  constructor.prototype.fillTable = function (data) {
    console.time('a');
    var tbody = d3.select($('.a-chart-table tbody').get(0))

    // create a row for each object in the data
    var rows = tbody.selectAll("tr")
        .data(data)
        .enter()
        .append("tr");

    // create a cell in each row for each column

    var cells = rows.selectAll("td")
        .data(function (row) {
          return [row.date, row.value];
        })
        .enter()
        .append("td")
        .html(function (d) {
          return d;
        });

    console.timeEnd('a');
    return tbody;
  };

  return constructor;
}();