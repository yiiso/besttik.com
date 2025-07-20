@extends('layouts.app')

@section('title', __('messages.verify_email_title'))
@section('description', __('messages.verify_email_description'))

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            {{ __('messages.verify_email_title') }}
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            {{ __('messages.verify_email_description') }}
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="text-center">
                <div class="mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-gray-600">{{ __('messages.check_email') }}</p>
                </div>

                <div class="space-y-4">
                    <form id="resendForm" class="space-y-4">
                        @csrf
                        <input type="hidden" id="userEmail" name="email" value="{{ auth()->user()->email }}">
                        <button type="submit" id="resendBtn"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            {{ __('messages.resend_verification') }}
                        </button>
                    </form>

                    <div class="text-sm">
                        <a href="{{ localized_url('/') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            {{ __('messages.back_to_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 从localStorage获取用户邮箱（如果有的话）
    const userEmail = localStorage.getItem('pending_verification_email');
    if (userEmail) {
        document.getElementById('userEmail').value = userEmail;
    }

    // 处理重新发送验证邮件
    const resendForm = document.getElementById('resendForm');
    const resendBtn = document.getElementById('resendBtn');

    resendForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = document.getElementById('userEmail').value;
        if (!email) {
            showToast('{{ __("messages.email_required") }}', 'error');
            return;
        }

        resendBtn.disabled = true;
        resendBtn.textContent = '{{ __("messages.sending") ?? "Sending..." }}';

        try {
            const response = await fetch('/email/resend', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            });

            const data = await response.json();

            if (response.ok) {
                showToast(data.message, 'success');
            } else {
                showToast(data.message || '{{ __("messages.error_occurred") ?? "An error occurred" }}', 'error');
            }
        } catch (error) {
            console.error('Resend verification error:', error);
            showToast('{{ __("messages.network_error") }}', 'error');
        } finally {
            resendBtn.disabled = false;
            resendBtn.textContent = '{{ __("messages.resend_verification") }}';
        }
    });
});

// Toast notification function
function showToast(message, type = 'info') {
    const existingToast = document.getElementById('toast');
    if (existingToast) {
        existingToast.remove();
    }

    const toast = document.createElement('div');
    toast.id = 'toast';
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;

    if (type === 'success') {
        toast.className += ' bg-green-600';
    } else if (type === 'error') {
        toast.className += ' bg-red-600';
    } else {
        toast.className += ' bg-blue-600';
    }

    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}
</script>
@endsection
