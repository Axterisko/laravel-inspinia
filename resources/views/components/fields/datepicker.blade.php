<div class="form-group{{isset($class) ? ' '.$class : ''}}{{ $errors->has($field['name']) ? ' has-error' : '' }}">
  <label class="control-label">{{ !empty($field['label']) ? $field['label'] : Str::title(str_replace('_', ' ', Str::snake($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}</label>
  <div class="input-group">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    <input type="text"
      class="form-control js-datepicker"
      name="{{ $field['name'] }}"
      value="{{ old($field['name'], isset($model) ? $model->{$field['name']} : null) }}"{{ !empty($field['required']) ? 'required' : '' }}
      data-date-format="{{ !empty($field['date-format']) ? $field['date-format'] : 'yyyy-mm-dd' }}"
      data-date-z-index-offset="1001"
      >
  </div>
  @if ($errors->has($field['name']))
  <span class="help-block">{{ $errors->first($field['name']) }}</span>
  @endif
</div>
