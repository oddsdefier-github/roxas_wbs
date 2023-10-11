import {hasProperty, pushUnique} from '../../lib/utils.js';
import {today, dateValue, addDays, addWeeks, dayOfTheWeekOf, getWeek} from '../../lib/date.js';
import {formatDate} from '../../lib/date-format.js';
import {parseHTML, showElement, hideElement} from '../../lib/dom.js';
import daysTemplate from '../templates/daysTemplate.js';
import calendarWeeksTemplate from '../templates/calendarWeeksTemplate.js';
import View from './View.js';

export default class DaysView extends View {
  constructor(picker) {
    super(picker, {
      id: 0,
      name: 'days',
      cellClass: 'day',
    });
  }

  init(options, onConstruction = true) {
    if (onConstruction) {
      const inner = parseHTML(daysTemplate).firstChild;
      this.dow = inner.firstChild;
      this.grid = inner.lastChild;
      this.element.appendChild(inner);
    }
    super.init(options);
  }

  setOptions(options) {
    let updateDOW;

    if (hasProperty(options, 'minDate')) {
      this.minDate = options.minDate;
    }
    if (hasProperty(options, 'maxDate')) {
      this.maxDate = options.maxDate;
    }
    if (options.datesDisabled) {
      this.datesDisabled = options.datesDisabled;
    }
    if (options.daysOfWeekDisabled) {
      this.daysOfWeekDisabled = options.daysOfWeekDisabled;
      updateDOW = true;
    }
    if (options.daysOfWeekHighlighted) {
      this.daysOfWeekHighlighted = options.daysOfWeekHighlighted;
    }
    if (options.todayHighlight !== undefined) {
      this.todayHighlight = options.todayHighlight;
    }
    if (options.weekStart !== undefined) {
      this.weekStart = options.weekStart;
      this.weekEnd = options.weekEnd;
      updateDOW = true;
    }
    if (options.locale) {
      const locale = this.locale = options.locale;
      this.dayNames = locale.daysMin;
      this.switchLabelFormat = locale.titleFormat;
      updateDOW = true;
    }
    if (options.beforeShowDay !== undefined) {
      this.beforeShow = typeof options.beforeShowDay === 'function'
        ? options.beforeShowDay
        : undefined;
    }

    if (options.calendarWeeks !== undefined) {
      if (options.calendarWeeks && !this.calendarWeeks) {
        const weeksElem = parseHTML(calendarWeeksTemplate).firstChild;
        this.calendarWeeks = {
          element: weeksElem,
          dow: weeksElem.firstChild,
          weeks: weeksElem.lastChild,
        };
        this.element.insertBefore(weeksElem, this.element.firstChild);
      } else if (this.calendarWeeks && !options.calendarWeeks) {
        this.element.removeChild(this.calendarWeeks.element);
        this.calendarWeeks = null;
      }
    }
    if (options.showDaysOfWeek !== undefined) {
      if (options.showDaysOfWeek) {
        showElement(this.dow);
        if (this.calendarWeeks) {
          showElement(this.calendarWeeks.dow);
        }
      } else {
        hideElement(this.dow);
        if (this.calendarWeeks) {
          hideElement(this.calendarWeeks.dow);
        }
      }
    }

    // update days-of-week when locale, daysOfweekDisabled or weekStart is changed
    if (updateDOW) {
      Array.from(this.dow.children).forEach((el, index) => {
        const dow = (this.weekStart + index) % 7;
        el.textContent = this.dayNames[dow];
        el.className = this.daysOfWeekDisabled.includes(dow) ? 'dow disabled text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400 cursor-not-allowed' : 'dow text-center h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400';
      });
    }
  }

  // Apply update on the focused date to view's settings
  updateFocus() {
    const viewDate = new Date(this.picker.viewDate);
    const viewYear = viewDate.getFullYear();
    const viewMonth = viewDate.getMonth();
    const firstOfMonth = dateValue(viewYear, viewMonth, 1);
    const start = dayOfTheWeekOf(firstOfMonth, this.weekStart, this.weekStart);

    this.first = firstOfMonth;
    this.last = dateValue(viewYear, viewMonth + 1, 0);
    this.start = start;
    this.focused = this.picker.viewDate;
  }

  // Apply update on the selected dates to view's settings
  updateSelection() {
    const {dates, rangepicker} = this.picker.datepicker;
    this.selected = dates;
    if (rangepicker) {
      this.range = rangepicker.dates;
    }
  }

   // Update the entire view UI
  render() {
    // update today marker on ever render
    this.today = this.todayHighlight ? today() : undefined;
    // refresh disabled dates on every render in order to clear the ones added
    // by beforeShow hook at previous render
    this.disabled = [...this.datesDisabled];

    const switchLabel = formatDate(this.focused, this.switchLabelFormat, this.locale);
    this.picker.setViewSwitchLabel(switchLabel);
    this.picker.setPrevBtnDisabled(this.first <= this.minDate);
    this.picker.setNextBtnDisabled(this.last >= this.maxDate);

    if (this.calendarWeeks) {
      // start of the UTC week (Monday) of the 1st of the month
      const startOfWeek = dayOfTheWeekOf(this.first, 1, 1);
      Array.from(this.calendarWeeks.weeks.children).forEach((el, index) => {
        el.textContent = getWeek(addWeeks(startOfWeek, index));
      });
    }
    Array.from(this.grid.children).forEach((el, index) => {
      const classList = el.classList;
      const current = addDays(this.start, index);
      const date = new Date(current);
      const day = date.getDay();

      el.className = `datepicker-cell hover:bg-gray-100 dark:hover:bg-gray-600 block flex-1 leading-9 border-0 rounded-lg cursor-pointer text-center text-gray-900 dark:text-white font-semibold text-sm ${this.cellClass}`;
      el.dataset.date = current;
      el.textContent = date.getDate();

      if (current < this.first) {
        classList.add('prev', 'text-gray-500', 'dark:text-white');
      } else if (current > this.last) {
        classList.add('next', 'text-gray-500', 'dark:text-white');
      }
      if (this.today === current) {
        classList.add('today', 'bg-gray-100', 'dark:bg-gray-600');
      }
      if (current < this.minDate || current > this.maxDate || this.disabled.includes(current)) {
        classList.add('disabled', 'cursor-not-allowed');
      }
      if (this.daysOfWeekDisabled.includes(day)) {
        classList.add('disabled', 'cursor-not-allowed');
        pushUnique(this.disabled, current);
      }
      if (this.daysOfWeekHighlighted.includes(day)) {
        classList.add('highlighted');
      }
      if (this.range) {
        const [rangeStart, rangeEnd] = this.range;
        if (current > rangeStart && current < rangeEnd) {
          classList.add('range', 'bg-gray-200', 'dark:bg-gray-600');
          classList.remove('rounded-lg', 'rounded-l-lg', 'rounded-r-lg')
        }
        if (current === rangeStart) {
          classList.add('range-start', 'bg-gray-100', 'dark:bg-gray-600', 'rounded-l-lg');
          classList.remove('rounded-lg', 'rounded-r-lg');
        }
        if (current === rangeEnd) {
          classList.add('range-end', 'bg-gray-100', 'dark:bg-gray-600', 'rounded-r-lg');
          classList.remove('rounded-lg', 'rounded-l-lg');
        }
      }
      if (this.selected.includes(current)) {
        classList.add('selected', 'bg-blue-700', 'text-white', 'dark:bg-blue-600', 'dark:text-white');
        classList.remove('text-gray-900', 'text-gray-500', 'hover:bg-gray-100', 'dark:text-white', 'dark:hover:bg-gray-600', 'dark:bg-gray-600', 'bg-gray-100', 'bg-gray-200');
      }
      if (current === this.focused) {
        classList.add('focused');
      }

      if (this.beforeShow) {
        this.performBeforeHook(el, current, current);
      }
    });
  }

  // Update the view UI by applying the changes of selected and focused items
  refresh() {
    const [rangeStart, rangeEnd] = this.range || [];
    this.grid
      .querySelectorAll('.range, .range-start, .range-end, .selected, .focused')
      .forEach((el) => {
        el.classList.remove('range', 'range-start', 'range-end', 'selected', 'bg-blue-700', 'text-white', 'dark:bg-blue-600', 'dark:text-white', 'focused');
        el.classList.add('text-gray-900', 'rounded-lg', 'dark:text-white');
      });
    Array.from(this.grid.children).forEach((el) => {
      const current = Number(el.dataset.date);
      const classList = el.classList;
      classList.remove('bg-gray-200', 'dark:bg-gray-600', 'rounded-l-lg', 'rounded-r-lg')
      if (current > rangeStart && current < rangeEnd) {
        classList.add('range', 'bg-gray-200', 'dark:bg-gray-600');
        classList.remove('rounded-lg');
      }
      if (current === rangeStart) {
        classList.add('range-start', 'bg-gray-200', 'dark:bg-gray-600', 'rounded-l-lg');
        classList.remove('rounded-lg', 'rounded-r-lg');
      }
      if (current === rangeEnd) {
        classList.add('range-end', 'bg-gray-200', 'dark:bg-gray-600', 'rounded-r-lg');
        classList.remove('rounded-lg', 'rounded-l-lg');
      }
      if (this.selected.includes(current)) {
        classList.add('selected', 'bg-blue-700', 'text-white', 'dark:bg-blue-600', 'dark:text-white');
        classList.remove('text-gray-900', 'hover:bg-gray-100', 'dark:text-white', 'dark:hover:bg-gray-600', 'bg-gray-100', 'bg-gray-200', 'dark:bg-gray-600');
      }
      if (current === this.focused) {
        classList.add('focused');
      }
    });
  }

  // Update the view UI by applying the change of focused item
  refreshFocus() {
    const index = Math.round((this.focused - this.start) / 86400000);
    this.grid.querySelectorAll('.focused').forEach((el) => {
      el.classList.remove('focused');
    });
    this.grid.children[index].classList.add('focused');
  }
}
