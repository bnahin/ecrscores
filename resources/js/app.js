/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap')

/** Static Table Popover **/

/**
 * If in 8th grade tab, view category info for 11th grade
 * If in 11th grade tab, view category info for 8th grade
 * Hover over icon (Info icon)
 */

/** View Charts **/
let ViewTableHelper = {
  showPeekPopover: (td, grade, content) => {
    td.popover({
      content  : content,
      title    : 'Result in SBAC ' + grade,
      container: 'body',
      placement: 'right',
      html     : true,
      trigger  : 'click'
    }).popover('show')
  }
}
let compareTableDt, sbacLoaded
$(function () {
    if ($('.static-table').length) {
      compareTableDt = $('.static-table').DataTable({
        drawCallback: (e) => {
          let id = e.sTableId.split('-')[0]
          if (location.hash === '#' + id)
            setTimeout(() => $('#' + id + '-table').DataTable().fixedHeader.enable(), 100)
          $('.' + id + '-load').remove()
          let course = $('#psat11-course').val()
          loadPSATAverages(course, $('#past11-exam').val(), null, true)
          if (!sbacLoaded) {
            loadSBACAverages(course)
            sbacLoaded = true
          }
        },
        lengthMenu  : [10, 20, 30, 50],
        fixedHeader : true
      })

      function loadSparklines (destroy) {
        if (destroy) {
          $('.sparklines-box').sparkline('destroy')
          $('.sparklines-line').sparkline('destroy')
          return loadSparklines(false)
        }
        $('.sparklines-box').sparkline('html', {type: 'box'})
        $('.sparklines-pie').sparkline('html', {
          type               : 'pie',
          sliceColors        : ['gray', 'red', 'yellow', 'lightgreen', 'darkgreen'],
          tooltipFormat      : '{{offset:offset}} ({{percent.1}}%)',
          tooltipValueLookups: {
            'offset': {
              0: 'No Score',
              1: 'Standard Not Met',
              2: 'Near Standard',
              3: 'Standard Met',
              4: 'Standard Exceeded'
            }
          },
        })
      }

      loadSparklines(false)
      compareTableDt.fixedHeader.disable()
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        loadSparklines(true)
        compareTableDt.fixedHeader.disable()
        let target = $('#' + e.target.hash.substr(1) + '-table')
        //Prevent other tables from floating
        target.DataTable().fixedHeader.enable()
      })

      //Popover Ajax
      $('.static-table').find('td').on('click', function (e) {
        let td = $(this)
        let grade  = $(this).data('grade'),
            ssid   = $(this).data('ssid'),
            fields = $(this).data('fields').split(',')
        // ViewTableHelper.showPeekPopover(td, grade, 'Loading...')
        $.ajax({
          url    : '/ajax/getCellData',
          data   : {
            grade : grade,
            ssid  : ssid,
            fields: fields
          },
          type   : 'POST',
          success: result => {
            ViewTableHelper.showPeekPopover(td, grade, result)
          },
          error  : () => ViewTableHelper.showPeekPopover(td, grade, '<em>Error - No Data</em>')
        })
      })
    }
  }
)

/** Functions **/
function loadPSATAverages (c, e, col, th) {
  $.post('/ajax/getPSATAverages', {
    course: c,
    exam  : e
  }, function (result) {
    for (let field in result) {
      if (result.hasOwnProperty(field)) {
        let selector = '#'
        if (th) selector += 'th-'
        selector += 'avg-' + field
        if (!th && col) selector += '-' + col

        $(selector).html(result[field])
      }
    }
  })
}

function loadSBACAverages (c) {
  $.post('/ajax/getSBACAverages', {
    course: c
  }, function (result) {
    for (let grade in result) {
      if (result.hasOwnProperty(grade)) {
        for (let field in result[grade]) {
          if (result[grade].hasOwnProperty(field)) {
            let selector = '#sbac-avg-' + field + '-' + grade
            $(selector).html(result[grade][field])
          }
        }
      }
    }
  })
}

/** Compare Tab **/
let CompareTableHelper = {
  cellToColor: (header) => {
    switch (header) {
      case 'Standard Not Met':
        return 'danger'
      case 'Near Standard':
        return 'warning'
      case 'Standard Met':
      case 'Standard Exceeded':
        return 'success'
      default:
        return ''
    }
  }
}
$(function () {
  if ($('.compare-table').length) {
    let dataTable
    $('.compare-select').val(null).trigger('change')
    $('.select2-course').select2({
      templateSelection: course => course.element.dataset.label
    }).on('select2:select', function (e) {
      let data = e.params.data,
          col  = data.element.dataset.col,
          exam = $('#examselect-' + col).find(':selected').val()
      if (exam.length) loadData(col)
      else destroyTable(col)
    })
    $('.select2-exam').select2()
      .on('select2:select', function (e) {
        let data   = e.params.data,
            col    = data.element.dataset.col,
            course = $('#courseselect-' + col).find(':selected').val()
        if (course.length) loadData(col)
        else destroyTable(col)
      })

    function loadData (col) {
      destroyTable(col)
      //console.log('Loading data to ' + col)

      //Get selected values
      let exam   = $('#examselect-' + col).find(':selected').val(),
          course = $('#courseselect-' + col).find(':selected').val()
      if (!exam.length || !course.length) return null

      //Get type
      let type        = exam.split('-')[0],
          table       = $('#' + type + '-compare-' + col),
          filterBox   = $('#filter-box-' + col),
          sbacStatBox = $('#column-box-' + col),
          columns     = []
      //console.log(type) //SBAC|PSAT|...

      //Show and Initialize data table, with AJAX
      if (type === 'psat') {
        columns = [
          {name: 'fname'},
          {name: 'lname'},
          {name: 'readwrite'},
          {name: 'math'},
          {name: 'total'}
        ]
        filterBox.hide()
        sbacStatBox.show()
      } else {
        sbacStatBox.hide()
        filterBox.show()
        let i = 2
        let checkboxes = filterBox.find('input:checkbox'),
            numBoxes   = checkboxes.length
        columns = Array.matrix(numBoxes - 1, 1, {})
        columns[0] = {name: 'fname', visible: true}
        columns[1] = {name: 'lname', visible: true}
        checkboxes.each(function () {
          columns[i++] = {
            name   : $(this).val(),
            visible: $(this).prop('checked')
          }
        })
      }
      dataTable = table.show().DataTable({
        serverSide : true,
        processing : true,
        responsive : true,
        columns    : columns,
        lengthMenu : [10, 20, 30, 50],
        rowCallback: (r, d) => compareTableColors(r, d, type),
        ajax       : {
          type: 'POST',
          url : '/ajax/getTableData',
          data: {
            course: course,
            exam  : exam
          }
        }
      })
      loadCompareSparklines(course, exam, col)
      loadPSATAverages(course, exam, col)

      /** Sparkline Graphs **/
      function loadCompareSparklines (c, e, col) {
        $.post('/ajax/getSparklines',
          {
            course: c,
            exam  : e
          }, result => {
            for (let chartType in result) {
              if (result.hasOwnProperty(chartType)) {
                for (let field in result[chartType]) {
                  if (result[chartType].hasOwnProperty(field)) {
                    if (chartType === 'box')
                      $('#sl-' + field + '-' + col).sparkline(result[chartType][field].split(','), {type: 'box'})
                    else if (chartType === 'pie')
                      $('#sl-' + field + '-' + col).sparkline(result[chartType][field].split(','), {
                        type               : 'pie',
                        sliceColors        : ['gray', 'red', 'yellow', 'lightgreen', 'darkgreen'],
                        tooltipFormat      : '{{offset:offset}} ({{percent.1}}%)',
                        tooltipValueLookups: {
                          'offset': {
                            0: 'No Score',
                            1: 'Standard Not Met',
                            2: 'Near Standard',
                            3: 'Standard Met',
                            4: 'Standard Exceeded'
                          }
                        },
                      })
                  }
                }
              }
            }
          }
        )
      }

    }

    function destroyTable (col) {
      let table     = $('.compare-table[id$="compare-' + col + '"]'),
          filterBox = $('#filter-box-' + col)
      filterBox.hide()
      table.DataTable().destroy()
      table.hide()
    }

    function compareTableColors (row, data, type) {
      if (type === 'psat') {
        $('td:eq(4)', row).addClass('success')
      } else {
        $(row).find('td').each(function () {
          let index = $(this).index(),
              th    = $(dataTable.column(index).header())

          $('td:eq(' + index + ')', row).addClass(CompareTableHelper.cellToColor($(this).text()))

        })
      }
    }

    /** Filter Boxes **/
    $('.filter-box').find('input:checkbox').change(function () {
      let table = $('#' + $(this).parents('.filter-box-container').data('controls'))
      table.DataTable().column($(this).val() + ':name').visible($(this).prop('checked'))
      table.DataTable().columns.adjust().draw()
    })
  }
})

/** Homepage Charts **/
$(function () {
  if ($('.static-table').length || $('#admin-select').length) return null

  let mathColor = 'rgba(255, 99, 132)',
      elaColor  = 'rgba(153, 102, 255)'
  /** PSAT Averages **/
  $.get('/ajax/getAverages/psat', function (response) {
    let mathData      = [],
        readingData   = [],
        years         = [],
        mathColors    = [],
        readingColors = []

    for (let d in response.math)
      if (response.math.hasOwnProperty(d)) {
        mathData.push(response['math'][d])
        mathColors.push(mathColor)
      }

    for (let d in response.reading)
      if (response.reading.hasOwnProperty(d)) {
        readingData.push(response['reading'][d])
        readingColors.push(elaColor)
      }

    for (let d in response.years)
      if (response.years.hasOwnProperty(d)) {
        years.push(response['years'][d])
      }
    new Chart(document.getElementById('psat-averages'), {
      type   : 'bar',
      data   : {
        labels  : years,
        datasets: [{
          label          : 'Math',
          data           : mathData,
          fill           : true,
          backgroundColor: mathColors,
          borderWidth    : 1
        }, {
          label          : 'Reading/Writing',
          data           : readingData,
          fill           : true,
          backgroundColor: readingColors,
          borderWidth    : 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks  : {beginAtZero: true},
            stacked: true
          }],
          xAxes: [{
            stacked: true
          }]
        }
      }
    })
    $('#psat-averages').parent().siblings('.overlay').remove()
  })

  /** SBAC Averages **/
  $.get('/ajax/getAverages/sbac', function (response) {
    let mathData   = [],
        elaData    = [],
        years      = [],
        mathColors = [],
        elaColors  = []

    for (let d in response.math)
      if (response.math.hasOwnProperty(d)) {
        mathData.push(response['math'][d])
        mathColors.push(mathColor)
      }

    for (let d in response.ela)
      if (response.ela.hasOwnProperty(d)) {
        elaData.push(response['ela'][d])
        elaColors.push(elaColor)
      }

    for (let d in response.years)
      if (response.years.hasOwnProperty(d)) {
        years.push(response['years'][d])
      }
    setTimeout(() => {
      new Chart(document.getElementById('sbac-averages'), {
        type   : 'bar',
        data   : {
          labels  : years,
          datasets: [{
            label          : 'ELA Scale',
            data           : elaData,
            fill           : true,
            backgroundColor: elaColors,
            borderWidth    : 1
          }, {
            label          : 'Math Scale',
            data           : mathData,
            fill           : true,
            backgroundColor: mathColors,
            borderWidth    : 1
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks  : {beginAtZero: true},
              stacked: false
            }],
            xAxes: [{
              stacked: false
            }]
          }
        }
      })
      $('#sbac-averages').parent().siblings('.overlay').remove()
    }, 2000)
  })

  let levelColors = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(50, 245, 115)', 'rgb(6, 121, 44)']
  /** SBAC Math Levels **/
  $.get('/ajax/getLevels/math', function (response) {
    let data = []
    for (let d in response)
      if (response.hasOwnProperty(d))
        data.push(response[d]['total'])
    setTimeout(() => {
      new Chart(document.getElementById('math-levels'), {
        type: 'pie',
        data: {
          labels  : ['Standard Not Met', 'Near Standard', 'Meets Standard', 'Exceeds Standard'],
          datasets: [{
            label          : 'My First Dataset',
            data           : data,
            backgroundColor: levelColors
          }]
        }
      })
      $('#math-levels').parent().siblings('.overlay').remove()
    }, 1000)
  })

  /** SBAC ELA Levels **/
  $.get('/ajax/getLevels/ela', function (response) {
    let data = []
    for (let d in response)
      if (response.hasOwnProperty(d))
        data.push(response[d]['total'])
    setTimeout(() => {
      new Chart(document.getElementById('ela-levels'), {
        type: 'pie',
        data: {
          labels  : ['Standard Not Met', 'Near Standard', 'Meets Standard', 'Exceeds Standard'],
          datasets: [{
            label          : 'My First Dataset',
            data           : data,
            backgroundColor: levelColors
          }]
        }
      }, 3000)
      $('#ela-levels').parent().siblings('.overlay').remove()
    })
  })

  /** Timeout Loading **/
  setTimeout(() => $('.overlay').find('.fa').removeClass('fa-spinner fa-spin').addClass('fa-remove'), 15000)
})

/** Welcome Alert **/
$(function () {
//Display only on first visit
  if (Cookies.get('firstvisit') !== undefined) return null
  let content = document.createElement('div')
  content.innerHTML = `Welcome to the ECRCHS Scores Interface.
  You can use this app to retrieve and analyze student scrores from SBAC 8/11 and PSAT 11.
  Contact Blake Nahin, <a href="mailto:115602@ecrchs.org">115602@ecrchs.org</a>, 
  with questions, bugs, or feature requests.`
  swal({
    title  : 'Welcome!',
    icon   : 'info',
    content: content
  })
  Cookies.set('firstvisit', true, {expires: 365})
})

/** Admin Select **/
$(function () {
  if ($('#admin-select').length) {
    let input = $('#admin-select-email')
    input.select2()
  }
})