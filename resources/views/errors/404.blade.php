<x-blank>
    <style>
        .error-page {
            display: flex;
            align-items: center;
            background-color: rgb(249 250 251);
            padding-top: 6rem;
            padding-bottom: 6rem;
        }

        .error-page__container {
            width: 100%;
            max-width: 56rem;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .error-page__card {
            max-width: 56rem;
            margin-left: auto;
            margin-right: auto;
            overflow: hidden;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow:
                0 10px 15px -3px rgb(0 0 0 / 0.1),
                0 4px 6px -4px rgb(0 0 0 / 0.1);
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .error-page__content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .error-page__code {
            font-size: 3.75rem;
            line-height: 1;
            font-weight: 800;
            color: rgb(13 148 136);
        }

        .error-page__title {
            margin-top: 0.5rem;
            font-size: 1.5rem;
            line-height: 2rem;
            font-weight: 600;
            color: rgb(55 65 81);
        }

        .error-page__description {
            margin-top: 1rem;
            color: rgb(75 85 99);
        }

        .error-page__actions {
            margin-top: 1.5rem;
            display: none;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .error-page__button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
            transition: background-color 150ms ease;
        }

        .error-page__button--secondary {
            border: 1px solid rgb(229 231 235);
            color: rgb(55 65 81);
        }

        .error-page__button--secondary:hover {
            background-color: rgb(249 250 251);
        }

        @media (min-width: 640px) {
            .error-page__actions {
                flex-direction: row;
            }
        }
    </style>

    <section class="error-page">
        <div class="error-page__container">
            <div class="error-page__card">
                <div class="error-page__content">
                    <h1 class="error-page__code">
                        404
                    </h1>

                    <h2 class="error-page__title">
                        {{ __('backend.content_404') }}
                    </h2>

                    <p class="error-page__description">
                        الصفحة التي تبحث عنها غير موجودة أو تم نقلها. جرب أحد الخيارات أدناه.
                    </p>

                    <div class="error-page__actions">
                        <a href="{{ url('/') }}" class="error-page__button">
                            {{ __('backend.home') }}
                        </a>

                        <a href="{{ url('/contact') }}"
                           class="error-page__button error-page__button--secondary">
                            {{ __('backend.contact_us') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-blank>