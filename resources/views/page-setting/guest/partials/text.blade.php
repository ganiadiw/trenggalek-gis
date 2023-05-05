<section>
    <div class="flex space-x-2">
        <input type="text" name="value_text[]"
            value="{{ old('value', $guestPageSetting->value[$i]) }}" id="value"
            class="block w-full px-4 mb-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            autocomplete="off">
    </div>
</section>
