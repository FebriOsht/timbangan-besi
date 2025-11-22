@props(['title'])

<x-auth.layouts.auth-layout :title="$title">
    {{ $slot }}
</x-auth.layouts.auth-layout>
