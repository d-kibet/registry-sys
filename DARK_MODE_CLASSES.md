# Dark Mode Class Reference

This document provides quick reference for adding dark mode support to components.

## Common Element Classes

### Backgrounds
```
bg-white                 → bg-white dark:bg-gray-800
bg-gray-50               → bg-gray-50 dark:bg-gray-900
bg-gray-100              → bg-gray-100 dark:bg-gray-800
bg-gray-200              → bg-gray-200 dark:bg-gray-700
```

### Text Colors
```
text-gray-800            → text-gray-800 dark:text-gray-100
text-gray-700            → text-gray-700 dark:text-gray-200
text-gray-600            → text-gray-600 dark:text-gray-400
text-gray-500            → text-gray-500 dark:text-gray-500
```

### Borders
```
border-gray-200          → border-gray-200 dark:border-gray-700
border-gray-300          → border-gray-300 dark:border-gray-600
```

### Shadows
```
shadow-lg                → shadow-lg dark:shadow-gray-900/50
shadow-xl                → shadow-xl dark:shadow-gray-900/50
shadow-2xl               → shadow-2xl dark:shadow-gray-900/50
```

### Forms (Inputs, Textareas, Selects)
```
bg-white border-gray-300 text-gray-900
→ bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100

focus:border-uda-green-500 focus:ring-uda-green-500
→ focus:border-uda-green-500 dark:focus:border-uda-green-400 focus:ring-uda-green-500 dark:focus:ring-uda-green-400
```

### Buttons - Primary (UDA Colors)
```
bg-uda-green-500 hover:bg-uda-green-600 text-white
→ bg-uda-green-500 hover:bg-uda-green-600 dark:bg-uda-green-600 dark:hover:bg-uda-green-700 text-white
```

### Buttons - Secondary
```
bg-gray-200 hover:bg-gray-300 text-gray-800
→ bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200
```

### Buttons - Danger
```
bg-red-500 hover:bg-red-600 text-white
→ bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white
```

### Cards/Panels
```
bg-white rounded-lg shadow-md border border-gray-200 p-4
→ bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-700 p-4
```

### Tables
```
<!-- Table Container -->
bg-white shadow-md rounded-lg
→ bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-900/50 rounded-lg

<!-- Table Header -->
bg-gray-50 border-b border-gray-200
→ bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600

<!-- Table Header Text -->
text-gray-700 font-semibold
→ text-gray-700 dark:text-gray-200 font-semibold

<!-- Table Row -->
border-b border-gray-200 hover:bg-gray-50
→ border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50

<!-- Table Cell Text -->
text-gray-900
→ text-gray-900 dark:text-gray-100
```

### Modals/Dialogs
```
<!-- Backdrop -->
bg-black/50
→ bg-black/50 dark:bg-black/70

<!-- Modal Panel -->
bg-white rounded-lg shadow-xl
→ bg-white dark:bg-gray-800 rounded-lg shadow-xl dark:shadow-gray-900/70
```

### Badges/Tags
```
<!-- Success Badge -->
bg-green-100 text-green-800
→ bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400

<!-- Warning Badge -->
bg-yellow-100 text-yellow-800
→ bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400

<!-- Danger Badge -->
bg-red-100 text-red-800
→ bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
```

### Links
```
text-uda-green-600 hover:text-uda-green-700
→ text-uda-green-600 dark:text-uda-green-400 hover:text-uda-green-700 dark:hover:text-uda-green-300
```

### Alerts/Messages
```
<!-- Success Alert -->
bg-green-50 border-green-200 text-green-800
→ bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-800 dark:text-green-400

<!-- Error Alert -->
bg-red-50 border-red-200 text-red-800
→ bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-400

<!-- Info Alert -->
bg-blue-50 border-blue-200 text-blue-800
→ bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-400
```

### Dividers
```
border-t border-gray-200
→ border-t border-gray-200 dark:border-gray-700
```

## Quick Find & Replace

Use these patterns for bulk updates:

1. **White backgrounds**: `bg-white` → `bg-white dark:bg-gray-800`
2. **Gray backgrounds**: `bg-gray-50` → `bg-gray-50 dark:bg-gray-900`
3. **Dark text**: `text-gray-900` → `text-gray-900 dark:text-gray-100`
4. **Medium text**: `text-gray-600` → `text-gray-600 dark:text-gray-400`
5. **Borders**: `border-gray-200` → `border-gray-200 dark:border-gray-700`
6. **Shadows**: `shadow-lg` → `shadow-lg dark:shadow-gray-900/50`

## Add Transition
For smooth dark mode transitions, add:
```
transition-colors duration-200
```

## Testing
1. Toggle dark mode using the button in header
2. Check all pages in both modes
3. Verify forms are readable
4. Check modals and dropdowns
5. Test on mobile devices
