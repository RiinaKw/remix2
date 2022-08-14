<?php

namespace Remix\Utilities;

/**
 * Utility class for text output.
 *
 * @package Remix\Utilities
 */
class Cli extends Output
{
    /**
     * Definition of text foreground decoration.
     */
    private const TEXT_COLORS = array(
        'black'         => '30',
        'dark_gray'     => '30',
        'blue'          => '34',
        'dark_blue'     => '34',
        'light_blue'    => '34',
        'green'         => '32',
        'light_green'   => '32',
        'cyan'          => '36',
        'light_cyan'    => '36',
        'red'           => '31',
        'light_red'     => '31',
        'purple'        => '35',
        'light_purple'  => '35',
        'light_yellow'  => '33',
        'yellow'        => '33',
        'light_gray'    => '37',
        'white'         => '37',
    );

    /**
     * Definition of text background decoration.
     */
    private const BACKGROUND_COLORS = array(
        'black'      => '40',
        'red'        => '41',
        'green'      => '42',
        'yellow'     => '43',
        'blue'       => '44',
        'magenta'    => '45',
        'cyan'       => '46',
        'light_gray' => '47',
    );

    /**
     * Definition of text decoration.
     */
    private const TEXT_DECORATION = array(
        'bold'      => '1',
        'underline' => '4',
    );

    /**
     * A code indicating the start of character decoration.
     */
    public const DECORATION_START = "\033[";

    /**
     * A code indicating the end of character decoration.
     */
    public const DECORATION_END = 'm';

    public static function line(string $output = ''): void
    {
        echo $output, "\n";
    }

    public static function lineDecorate(
        string $output = '',
        string $foreground_color = '',
        string $background_color = '',
        string $dec = ''
    ): void {
        $output = static::decorate($output, $foreground_color, $background_color, $dec);
        static::line($output);
    }

    /**
     * Decorate the text.
     *
     * @param string $text              text to decorate
     * @param string $foreground_color  text foreground color
     * @param string $background_color  text background color
     * @param string $dec               other decorations
     * @return string   decorated text
     */
    public static function decorate(
        string $text,
        string $foreground_color = '',
        string $background_color = '',
        string $dec = ''
    ): string {
        $foreground_color = $foreground_color ?: 'white';
        $background_color = $background_color ?: 'black';

        $foreground_code = self::TEXT_COLORS[$foreground_color];
        $codes = [$foreground_code];

        if ($background_color) {
            $background_code = self::BACKGROUND_COLORS[$background_color];
            $codes[] = $background_code;
        }

        if ($dec) {
            $codes[] = self::TEXT_DECORATION[$dec];
        }

        $code = implode(';', $codes);

        $left = self::DECORATION_START . $code . self::DECORATION_END;
        $right = self::DECORATION_START . '0' . self::DECORATION_END;
        return $left . $text . $right;
    }

    /**
     * Remove text decoration.
     *
     * @param string $string
     * @return string
     */
    public static function trimDecoration(string $string): string
    {
        $regex = '/' . str_replace('[', '\\[', static::DECORATION_START) . '.*?m/';
        return preg_replace($regex, '', trim($string));
    }
}
