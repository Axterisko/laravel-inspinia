<div class="form-group{{isset($class) ? ' '.$class : ''}}{{ $errors->has($field['name']) ? ' has-error' : '' }}">
    <label class="control-label">{{ !empty($field['label']) ? $field['label'] : Str::title(str_replace('_', ' ', Str::snake($field['name']))) }}{{ !empty($field['required']) ? '*' : '' }}</label>
  <select class="form-control js-select2" name="{{ $field['name'] }}" {{ isset($field['multiple']) ? 'multiple' : '' }}>
    @foreach ($field['options'] as $option)
    <option value="{{ $option['value'] }}" {{ $option['value'] == old($field['name'], isset($model) ? $model->{$field['name']} : null) ? 'selected' : '' }}>{{ $option['text'] }}</option>
    @endforeach
  </select>
  @if ($errors->has($field['name']))
  <span class="help-block">{{ $errors->first($field['name']) }}</span>
  @endif
</div>
