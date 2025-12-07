import { Temporal } from '@js-temporal/polyfill';
import { computed, onMounted, onUnmounted, ref, unref, type Ref } from 'vue';

export interface RelativeDateOptions {
    locale?: string;
    weekThresholdDays?: number;
    updateEveryMs?: number;
}

/**
 * Returns a reactive, human-friendly string for a given ISO date string.
 * - If older than the threshold (default 7 days): formats as absolute date (fr-FR).
 * - Otherwise: formats as relative time (e.g., "il y a 3 min").
 */
export function useRelativeDate(
    date: Ref<string> | string,
    options: RelativeDateOptions = {},
) {
    const {
        locale = 'fr',
        weekThresholdDays = 7,
        updateEveryMs = undefined, // 60_000, update every minute
    } = options;

    const tick = ref(0);
    let timer: number | undefined;

    onMounted(() => {
        timer = updateEveryMs
            ? window.setInterval(() => {
                  tick.value++;
              }, updateEveryMs)
            : undefined;
    });

    onUnmounted(() => {
        if (timer) {
            clearInterval(timer);
        }
    });

    const formatted = computed<string>(() => {
        // read both to establish reactivity
        void tick.value;
        const dateString = unref(date);
        if (!dateString) {
            return '';
        }

        const eventTime = Temporal.Instant.from(dateString);
        const now = Temporal.Now.instant();
        const duration = now.since(eventTime);

        const days = duration.total('days');
        if (days > weekThresholdDays) {
            return eventTime.toLocaleString(
                locale === 'fr' ? 'fr-FR' : locale,
                {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                },
            );
        }

        const rtf = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });
        if (days >= 1) return rtf.format(-Math.round(days), 'day');

        const hours = duration.total('hours');
        if (hours >= 1) return rtf.format(-Math.round(hours), 'hour');

        const minutes = duration.total('minutes');
        return rtf.format(-Math.round(minutes), 'minute');
    });

    return formatted.value;
}

/**
 * Returns a stable formatter function to convert ISO date strings to
 * human-friendly strings, without reactivity. Useful in templates/loops.
 */
export function useRelativeDateFormatter(options: RelativeDateOptions = {}) {
    const { locale = 'fr', weekThresholdDays = 7 } = options;

    return function format(dateString: string): string {
        if (!dateString) {
            return '';
        }

        const eventTime = Temporal.Instant.from(dateString);
        const now = Temporal.Now.instant();
        const duration = now.since(eventTime);

        const days = duration.total('days');
        if (days > weekThresholdDays) {
            return eventTime.toLocaleString(
                locale === 'fr' ? 'fr-FR' : locale,
                {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                },
            );
        }

        const rtf = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });
        if (days >= 1) return rtf.format(-Math.round(days), 'day');

        const hours = duration.total('hours');
        if (hours >= 1) return rtf.format(-Math.round(hours), 'hour');

        const minutes = duration.total('minutes');
        return rtf.format(-Math.round(minutes), 'minute');
    };
}
