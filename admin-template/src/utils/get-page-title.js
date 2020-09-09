import defaultSettings from '@/settings'

const title = defaultSettings.title || 'cc_forever'

export default function getPageTitle(pageTitle) {
  if (pageTitle) {
    return `${pageTitle} - ${title}`
  }
  return `${title}`
}
