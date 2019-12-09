<?php
namespace Qobo\Social\Utility;

/**
 * Class Utilities
 */
class ClassUtility
{
    /**
     * Wrapper around `class_uses` function. See php.net comments.
     *
     * @see https://secure.php.net/manual/en/function.class-uses.php
     * @param mixed $class An object (class instance) or a string (class name).
     * @param bool $autoload Whether to allow this function to load the class automatically through the __autoload() magic method.
     * @return mixed[]|bool Array on success, or FALSE on error.
     */
    public static function classUses($class, bool $autoload = true)
    {
        $traits = [];

        // Get all the traits of $class and its parent classes
        do {
            $className = is_object($class) ? get_class($class) : $class;
            if (class_exists($className, $autoload)) {
                $traits = array_merge(class_uses($class, $autoload), $traits);
            }
        } while ($class = get_parent_class($class));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            /** @var object|string $pop */
            $pop = array_pop($traitsToSearch);
            $new_traits = class_uses($pop, $autoload);
            $traits = array_merge($new_traits, $traits);
            $traitsToSearch = array_merge($new_traits, $traitsToSearch);
        };

        return array_unique($traits);
    }
}
